<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommission\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionAmountCreator;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionAmountCreatorInterface;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionCreator;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionCreatorInterface;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionMerchantCreator;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionMerchantCreatorInterface;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionRelationCreator;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionRelationCreatorInterface;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionStoreCreator;
use Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionStoreCreatorInterface;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionAmountExpander;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionAmountExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpander;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionMerchantRelationExpander;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionMerchantRelationExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionRelationExpander;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionRelationExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionStoreRelationExpander;
use Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionStoreRelationExpanderInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\CurrencyDataExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\CurrencyDataExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\ErrorExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\ErrorExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionDataExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionDataExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionGroupDataExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionGroupDataExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantDataExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\MerchantDataExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Extractor\StoreDataExtractor;
use Spryker\Zed\MerchantCommission\Business\Extractor\StoreDataExtractorInterface;
use Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouper;
use Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouperInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\CurrencyReader;
use Spryker\Zed\MerchantCommission\Business\Reader\CurrencyReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionAmountReader;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionAmountReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionGroupReader;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionGroupReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionReader;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantReader;
use Spryker\Zed\MerchantCommission\Business\Reader\MerchantReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Reader\StoreReader;
use Spryker\Zed\MerchantCommission\Business\Reader\StoreReaderInterface;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionAmountUpdater;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionAmountUpdaterInterface;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionMerchantUpdater;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionMerchantUpdaterInterface;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionRelationUpdater;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionRelationUpdaterInterface;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionStoreUpdater;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionStoreUpdaterInterface;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionUpdater;
use Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionUpdaterInterface;
use Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidator;
use Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\CurrencyExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\DescriptionLengthMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\KeyExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\KeyLengthMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\KeyUniqueMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionGroupExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\NameLengthMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\PriorityRangeMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\StoreExistsMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\ValidFromDateTimeMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\ValidityPeriodMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\ValidToDateTimeMerchantCommissionValidatorRule;
use Spryker\Zed\MerchantCommission\Business\Validator\Util\ErrorAdder;
use Spryker\Zed\MerchantCommission\Business\Validator\Util\ErrorAdderInterface;
use Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToCurrencyFacadeInterface;
use Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToMerchantFacadeInterface;
use Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToStoreFacadeInterface;
use Spryker\Zed\MerchantCommission\MerchantCommissionDependencyProvider;

/**
 * @method \Spryker\Zed\MerchantCommission\MerchantCommissionConfig getConfig()
 * @method \Spryker\Zed\MerchantCommission\Persistence\MerchantCommissionEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantCommission\Persistence\MerchantCommissionRepositoryInterface getRepository()
 */
class MerchantCommissionBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionReaderInterface
     */
    public function createMerchantCommissionReader(): MerchantCommissionReaderInterface
    {
        return new MerchantCommissionReader(
            $this->getRepository(),
            $this->createMerchantCommissionRelationExpander(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionCreatorInterface
     */
    public function createMerchantCommissionCreator(): MerchantCommissionCreatorInterface
    {
        return new MerchantCommissionCreator(
            $this->createMerchantCommissionCreateValidator(),
            $this->createMerchantCommissionExpander(),
            $this->getEntityManager(),
            $this->createMerchantCommissionRelationCreator(),
            $this->createMerchantCommissionGrouper(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionRelationCreatorInterface
     */
    public function createMerchantCommissionRelationCreator(): MerchantCommissionRelationCreatorInterface
    {
        return new MerchantCommissionRelationCreator(
            $this->createMerchantCommissionAmountCreator(),
            $this->createMerchantCommissionMerchantCreator(),
            $this->createMerchantCommissionStoreCreator(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionAmountCreatorInterface
     */
    public function createMerchantCommissionAmountCreator(): MerchantCommissionAmountCreatorInterface
    {
        return new MerchantCommissionAmountCreator(
            $this->createMerchantCommissionAmountExpander(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionMerchantCreatorInterface
     */
    public function createMerchantCommissionMerchantCreator(): MerchantCommissionMerchantCreatorInterface
    {
        return new MerchantCommissionMerchantCreator(
            $this->createMerchantReader(),
            $this->getEntityManager(),
            $this->createMerchantDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Creator\MerchantCommissionStoreCreatorInterface
     */
    public function createMerchantCommissionStoreCreator(): MerchantCommissionStoreCreatorInterface
    {
        return new MerchantCommissionStoreCreator(
            $this->createStoreReader(),
            $this->getEntityManager(),
            $this->createStoreDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionUpdaterInterface
     */
    public function createMerchantCommissionUpdater(): MerchantCommissionUpdaterInterface
    {
        return new MerchantCommissionUpdater(
            $this->createMerchantCommissionUpdateValidator(),
            $this->createMerchantCommissionExpander(),
            $this->getEntityManager(),
            $this->createMerchantCommissionRelationUpdater(),
            $this->createMerchantCommissionGrouper(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionRelationUpdaterInterface
     */
    public function createMerchantCommissionRelationUpdater(): MerchantCommissionRelationUpdaterInterface
    {
        return new MerchantCommissionRelationUpdater(
            $this->createMerchantCommissionAmountUpdater(),
            $this->createMerchantCommissionMerchantUpdater(),
            $this->createMerchantCommissionStoreUpdater(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionAmountUpdaterInterface
     */
    public function createMerchantCommissionAmountUpdater(): MerchantCommissionAmountUpdaterInterface
    {
        return new MerchantCommissionAmountUpdater(
            $this->createMerchantCommissionAmountExpander(),
            $this->createMerchantCommissionAmountReader(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionStoreUpdaterInterface
     */
    public function createMerchantCommissionStoreUpdater(): MerchantCommissionStoreUpdaterInterface
    {
        return new MerchantCommissionStoreUpdater(
            $this->createStoreReader(),
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createStoreDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Updater\MerchantCommissionMerchantUpdaterInterface
     */
    public function createMerchantCommissionMerchantUpdater(): MerchantCommissionMerchantUpdaterInterface
    {
        return new MerchantCommissionMerchantUpdater(
            $this->createMerchantReader(),
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createMerchantDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionRelationExpanderInterface
     */
    public function createMerchantCommissionRelationExpander(): MerchantCommissionRelationExpanderInterface
    {
        return new MerchantCommissionRelationExpander(
            $this->createMerchantCommissionExpander(),
            $this->createMerchantCommissionStoreRelationExpander(),
            $this->createMerchantCommissionMerchantRelationExpander(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionExpanderInterface
     */
    public function createMerchantCommissionExpander(): MerchantCommissionExpanderInterface
    {
        return new MerchantCommissionExpander(
            $this->createMerchantCommissionAmountReader(),
            $this->createMerchantCommissionGroupReader(),
            $this->createMerchantCommissionDataExtractor(),
            $this->createMerchantCommissionGroupDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionAmountExpanderInterface
     */
    public function createMerchantCommissionAmountExpander(): MerchantCommissionAmountExpanderInterface
    {
        return new MerchantCommissionAmountExpander(
            $this->createCurrencyReader(),
            $this->createCurrencyDataExtractor(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionMerchantRelationExpanderInterface
     */
    public function createMerchantCommissionMerchantRelationExpander(): MerchantCommissionMerchantRelationExpanderInterface
    {
        return new MerchantCommissionMerchantRelationExpander($this->createMerchantReader());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Expander\MerchantCommissionStoreRelationExpanderInterface
     */
    public function createMerchantCommissionStoreRelationExpander(): MerchantCommissionStoreRelationExpanderInterface
    {
        return new MerchantCommissionStoreRelationExpander($this->createStoreReader());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface
     */
    public function createMerchantCommissionCreateValidator(): MerchantCommissionValidatorInterface
    {
        return new MerchantCommissionValidator(
            $this->createErrorExtractor(),
            $this->getMerchantCommissionCreateValidationRules(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\MerchantCommissionValidatorInterface
     */
    public function createMerchantCommissionUpdateValidator(): MerchantCommissionValidatorInterface
    {
        return new MerchantCommissionValidator(
            $this->createErrorExtractor(),
            $this->getMerchantCommissionUpdateValidationRules(),
        );
    }

    /**
     * @return list<\Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface>
     */
    public function getMerchantCommissionCreateValidationRules(): array
    {
        return [
            $this->createCurrencyExistsMerchantCommissionValidatorRule(),
            $this->createDescriptionLengthMerchantCommissionValidatorRule(),
            $this->createKeyExistsMerchantCommissionValidatorRule(),
            $this->createKeyLengthMerchantCommissionValidatorRule(),
            $this->createKeyUniqueMerchantCommissionValidatorRule(),
            $this->createMerchantCommissionGroupExistsMerchantCommissionValidatorRule(),
            $this->createMerchantExistsMerchantCommissionValidatorRule(),
            $this->createNameLengthMerchantCommissionValidatorRule(),
            $this->createPriorityRangeMerchantCommissionValidatorRule(),
            $this->createStoreExistsMerchantCommissionValidatorRule(),
            $this->createValidFromDateTimeMerchantCommissionValidatorRule(),
            $this->createValidToDateTimeMerchantCommissionValidatorRule(),
            $this->createValidityPeriodMerchantCommissionValidatorRule(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface>
     */
    public function getMerchantCommissionUpdateValidationRules(): array
    {
        return [
            $this->createMerchantCommissionExistsMerchantCommissionValidatorRule(),
            $this->createCurrencyExistsMerchantCommissionValidatorRule(),
            $this->createDescriptionLengthMerchantCommissionValidatorRule(),
            $this->createMerchantCommissionGroupExistsMerchantCommissionValidatorRule(),
            $this->createMerchantExistsMerchantCommissionValidatorRule(),
            $this->createNameLengthMerchantCommissionValidatorRule(),
            $this->createPriorityRangeMerchantCommissionValidatorRule(),
            $this->createStoreExistsMerchantCommissionValidatorRule(),
            $this->createValidFromDateTimeMerchantCommissionValidatorRule(),
            $this->createValidToDateTimeMerchantCommissionValidatorRule(),
            $this->createValidityPeriodMerchantCommissionValidatorRule(),
        ];
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createCurrencyExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new CurrencyExistsMerchantCommissionValidatorRule(
            $this->createCurrencyReader(),
            $this->createCurrencyDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createDescriptionLengthMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new DescriptionLengthMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createKeyExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new KeyExistsMerchantCommissionValidatorRule(
            $this->getRepository(),
            $this->createMerchantCommissionDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createKeyLengthMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new KeyLengthMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createKeyUniqueMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new KeyUniqueMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createMerchantCommissionGroupExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new MerchantCommissionGroupExistsMerchantCommissionValidatorRule(
            $this->createMerchantCommissionGroupReader(),
            $this->createMerchantCommissionGroupDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createMerchantExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new MerchantExistsMerchantCommissionValidatorRule(
            $this->createMerchantReader(),
            $this->createMerchantDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createNameLengthMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new NameLengthMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createPriorityRangeMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new PriorityRangeMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createStoreExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new StoreExistsMerchantCommissionValidatorRule(
            $this->createStoreReader(),
            $this->createStoreDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createValidFromDateTimeMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new ValidFromDateTimeMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createValidityPeriodMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new ValidityPeriodMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createValidToDateTimeMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new ValidToDateTimeMerchantCommissionValidatorRule($this->createErrorAdder());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Rule\MerchantCommission\MerchantCommissionValidatorRuleInterface
     */
    public function createMerchantCommissionExistsMerchantCommissionValidatorRule(): MerchantCommissionValidatorRuleInterface
    {
        return new MerchantCommissionExistsMerchantCommissionValidatorRule(
            $this->getRepository(),
            $this->createMerchantCommissionDataExtractor(),
            $this->createErrorAdder(),
        );
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionAmountReaderInterface
     */
    public function createMerchantCommissionAmountReader(): MerchantCommissionAmountReaderInterface
    {
        return new MerchantCommissionAmountReader($this->getRepository());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\MerchantCommissionGroupReaderInterface
     */
    public function createMerchantCommissionGroupReader(): MerchantCommissionGroupReaderInterface
    {
        return new MerchantCommissionGroupReader($this->getRepository());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\MerchantReaderInterface
     */
    public function createMerchantReader(): MerchantReaderInterface
    {
        return new MerchantReader($this->getMerchantFacade());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\StoreReaderInterface
     */
    public function createStoreReader(): StoreReaderInterface
    {
        return new StoreReader($this->getStoreFacade());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Reader\CurrencyReaderInterface
     */
    public function createCurrencyReader(): CurrencyReaderInterface
    {
        return new CurrencyReader($this->getCurrencyFacade());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Grouper\MerchantCommissionGrouperInterface
     */
    public function createMerchantCommissionGrouper(): MerchantCommissionGrouperInterface
    {
        return new MerchantCommissionGrouper($this->createErrorExtractor());
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionDataExtractorInterface
     */
    public function createMerchantCommissionDataExtractor(): MerchantCommissionDataExtractorInterface
    {
        return new MerchantCommissionDataExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\MerchantCommissionGroupDataExtractorInterface
     */
    public function createMerchantCommissionGroupDataExtractor(): MerchantCommissionGroupDataExtractorInterface
    {
        return new MerchantCommissionGroupDataExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\MerchantDataExtractorInterface
     */
    public function createMerchantDataExtractor(): MerchantDataExtractorInterface
    {
        return new MerchantDataExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\StoreDataExtractorInterface
     */
    public function createStoreDataExtractor(): StoreDataExtractorInterface
    {
        return new StoreDataExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\CurrencyDataExtractorInterface
     */
    public function createCurrencyDataExtractor(): CurrencyDataExtractorInterface
    {
        return new CurrencyDataExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Extractor\ErrorExtractorInterface
     */
    public function createErrorExtractor(): ErrorExtractorInterface
    {
        return new ErrorExtractor();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Business\Validator\Util\ErrorAdderInterface
     */
    public function createErrorAdder(): ErrorAdderInterface
    {
        return new ErrorAdder();
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToMerchantFacadeInterface
     */
    public function getMerchantFacade(): MerchantCommissionToMerchantFacadeInterface
    {
        return $this->getProvidedDependency(MerchantCommissionDependencyProvider::FACADE_MERCHANT);
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToStoreFacadeInterface
     */
    public function getStoreFacade(): MerchantCommissionToStoreFacadeInterface
    {
        return $this->getProvidedDependency(MerchantCommissionDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \Spryker\Zed\MerchantCommission\Dependency\Facade\MerchantCommissionToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): MerchantCommissionToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(MerchantCommissionDependencyProvider::FACADE_CURRENCY);
    }
}