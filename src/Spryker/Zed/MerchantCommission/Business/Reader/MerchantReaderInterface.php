<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommission\Business\Reader;

use Generated\Shared\Transfer\MerchantCollectionTransfer;

interface MerchantReaderInterface
{
    /**
     * @param array<int> $merchantIds
     *
     * @return \Generated\Shared\Transfer\MerchantCollectionTransfer
     */
    public function getMerchantCollectionByMerchantIds(array $merchantIds): MerchantCollectionTransfer;

    /**
     * @param array<string> $merchantReferences
     *
     * @return \Generated\Shared\Transfer\MerchantCollectionTransfer
     */
    public function getMerchantCollectionByMerchantReferences(array $merchantReferences): MerchantCollectionTransfer;
}
