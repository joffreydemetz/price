<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Price;

/**
 * Price France formatter
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
class PriceFrance extends AbstractPrice 
{
  /**
   * {@inheritDoc}
   */
  public function __construct($price, $taxFree=true)
  {
    $this->taxRate            = 0.2;
    $this->thousandsSeparator = ' ';
    $this->decimals           = 2;
    $this->decimalsSeparator  = ',';
    $this->currency           = '€';
    $this->taxFreeSuffix      = 'HT';
    $this->taxFullSuffix      = 'TTC';
    
    parent::__construct($price, $taxFree);
  }
}
