<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommission\Business\Extractor;

use ArrayObject;

interface CurrencyDataExtractorInterface
{
    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\CurrencyTransfer> $currencyTransfers
     *
     * @return list<string>
     */
    public function extractCurrencyCodes(ArrayObject $currencyTransfers): array;

    /**
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\MerchantCommissionAmountTransfer> $merchantCommissionAmountTransfers
     *
     * @return list<string>
     */
    public function extractCurrencyCodesFromMerchantCommissionAmountTransfers(ArrayObject $merchantCommissionAmountTransfers): array;
}
