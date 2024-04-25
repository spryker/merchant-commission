<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommission\Business\Creator;

use ArrayObject;
use Generated\Shared\Transfer\MerchantCommissionCollectionRequestTransfer;
use Generated\Shared\Transfer\MerchantCommissionCollectionResponseTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouperInterface;
use Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface;
use Spryker\Zed\MerchantCommission\Persistence\MerchantCommissionEntityManagerInterface;

class MerchantCommissionCreator implements MerchantCommissionCreatorInterface
{
    use TransactionTrait;

    /**
     * @var \Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface
     */
    protected MerchantCommissionValidatorInterface $merchantCommissionValidator;

    /**
     * @var \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpanderInterface
     */
    protected MerchantCommissionExpanderInterface $merchantCommissionExpander;

    /**
     * @var \Spryker\Zed\MerchantCommission\Persistence\MerchantCommissionEntityManagerInterface
     */
    protected MerchantCommissionEntityManagerInterface $merchantCommissionEntityManager;

    /**
     * @var \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionRelationCreatorInterface
     */
    protected MerchantCommissionRelationCreatorInterface $merchantCommissionRelationCreator;

    /**
     * @var \Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouperInterface
     */
    protected MerchantCommissionGrouperInterface $merchantCommissionGrouper;

    /**
     * @param \Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface $merchantCommissionValidator
     * @param \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpanderInterface $merchantCommissionExpander
     * @param \Spryker\Zed\MerchantCommission\Persistence\MerchantCommissionEntityManagerInterface $merchantCommissionEntityManager
     * @param \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionRelationCreatorInterface $merchantCommissionRelationCreator
     * @param \Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouperInterface $merchantCommissionGrouper
     */
    public function __construct(
        MerchantCommissionValidatorInterface $merchantCommissionValidator,
        MerchantCommissionExpanderInterface $merchantCommissionExpander,
        MerchantCommissionEntityManagerInterface $merchantCommissionEntityManager,
        MerchantCommissionRelationCreatorInterface $merchantCommissionRelationCreator,
        MerchantCommissionGrouperInterface $merchantCommissionGrouper
    ) {
        $this->merchantCommissionValidator = $merchantCommissionValidator;
        $this->merchantCommissionExpander = $merchantCommissionExpander;
        $this->merchantCommissionEntityManager = $merchantCommissionEntityManager;
        $this->merchantCommissionRelationCreator = $merchantCommissionRelationCreator;
        $this->merchantCommissionGrouper = $merchantCommissionGrouper;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantCommissionCollectionRequestTransfer $merchantCommissionCollectionRequestTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantCommissionCollectionResponseTransfer
     */
    public function createMerchantCommissionCollection(
        MerchantCommissionCollectionRequestTransfer $merchantCommissionCollectionRequestTransfer
    ): MerchantCommissionCollectionResponseTransfer {
        $this->assertRequiredFields($merchantCommissionCollectionRequestTransfer);
        $merchantCommissionCollectionResponseTransfer = $this->merchantCommissionValidator->validate(
            $merchantCommissionCollectionRequestTransfer,
        );

        if ($merchantCommissionCollectionRequestTransfer->getIsTransactional() && $merchantCommissionCollectionResponseTransfer->getErrors()->count()) {
            return $merchantCommissionCollectionResponseTransfer;
        }

        [$validMerchantCommissionTransfers, $invalidMerchantCommissionTransfers] = $this->merchantCommissionGrouper->groupMerchantCommissionsByValidity(
            $merchantCommissionCollectionResponseTransfer,
        );

        if ($validMerchantCommissionTransfers->count() === 0) {
            return $merchantCommissionCollectionResponseTransfer;
        }

        $validMerchantCommissionTransfers = $this->merchantCommissionExpander->expandMerchantCommissionsWithMerchantCommissionGroups(
            $validMerchantCommissionTransfers,
        );
        $persistedMerchantCommissionTransfers = $this->getTransactionHandler()->handleTransaction(function () use ($validMerchantCommissionTransfers) {
            return $this->executeCreateMerchantCommissionCollectionTransaction($validMerchantCommissionTransfers);
        });

        return $merchantCommissionCollectionResponseTransfer->setMerchantCommissions(
            $this->merchantCommissionGrouper->mergeMerchantCommissionTransfers(
                $persistedMerchantCommissionTransfers,
                $invalidMerchantCommissionTransfers,
            ),
        );
    }

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantCommissionTransfer> $merchantCommissionTransfers
     *
     * @return \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantCommissionTransfer>
     */
    public function executeCreateMerchantCommissionCollectionTransaction(ArrayObject $merchantCommissionTransfers): ArrayObject
    {
        $persistedMerchantCommissionTransfers = new ArrayObject();
        foreach ($merchantCommissionTransfers as $entityIdentifier => $merchantCommissionTransfer) {
            $merchantCommissionTransfer = $this->merchantCommissionEntityManager->createMerchantCommission($merchantCommissionTransfer);
            $merchantCommissionTransfer = $this->merchantCommissionRelationCreator->createMerchantCommissionRelations($merchantCommissionTransfer);

            $persistedMerchantCommissionTransfers->offsetSet($entityIdentifier, $merchantCommissionTransfer);
        }

        return $persistedMerchantCommissionTransfers;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantCommissionCollectionRequestTransfer $merchantCommissionCollectionRequestTransfer
     *
     * @return void
     */
    protected function assertRequiredFields(MerchantCommissionCollectionRequestTransfer $merchantCommissionCollectionRequestTransfer): void
    {
        $merchantCommissionCollectionRequestTransfer
            ->requireIsTransactional()
            ->requireMerchantCommissions();

        foreach ($merchantCommissionCollectionRequestTransfer->getMerchantCommissions() as $merchantCommissionTransfer) {
            $merchantCommissionTransfer
                ->requireKey()
                ->requireName()
                ->requireCalculatorTypePlugin()
                ->requireIsActive()
                ->requireStoreRelation()
                ->requireMerchantCommissionGroup()
                ->getMerchantCommissionGroupOrFail()
                    ->requireUuid();

            $this->assertRequiredStoreRelationFields($merchantCommissionTransfer->getStoreRelationOrFail());

            if ($merchantCommissionTransfer->getMerchantCommissionAmounts()->count() !== 0) {
                $this->assertRequiredMerchantCommissionAmountFields($merchantCommissionTransfer->getMerchantCommissionAmounts());
            }

            if ($merchantCommissionTransfer->getMerchants()->count() !== 0) {
                $this->assertRequiredMerchantFields($merchantCommissionTransfer->getMerchants());
            }
        }
    }

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantCommissionAmountTransfer> $merchantCommissionAmountTransfers
     *
     * @return void
     */
    protected function assertRequiredMerchantCommissionAmountFields(ArrayObject $merchantCommissionAmountTransfers): void
    {
        foreach ($merchantCommissionAmountTransfers as $merchantCommissionAmountTransfer) {
            $merchantCommissionAmountTransfer
                ->requireCurrency()
                ->getCurrencyOrFail()
                    ->requireCode();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\StoreRelationTransfer $storeRelationTransfer
     *
     * @return void
     */
    protected function assertRequiredStoreRelationFields(StoreRelationTransfer $storeRelationTransfer): void
    {
        $storeRelationTransfer->requireStores();

        foreach ($storeRelationTransfer->getStores() as $storeTransfer) {
            $storeTransfer->requireName();
        }
    }

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantTransfer> $merchantTransfers
     *
     * @return void
     */
    protected function assertRequiredMerchantFields(ArrayObject $merchantTransfers): void
    {
        foreach ($merchantTransfers as $merchantTransfer) {
            $merchantTransfer->requireMerchantReference();
        }
    }
}
