<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Price;

/**
 * Price Interface
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
interface PriceInterface 
{
  /**
   * Set the display configuration
   * 
   * @param 	array       $config   Key/Value pairs of configuration for the display
   * @return 	PriceBase   The current object's instance for chaining
   */
  public function config(array $config=[]);
  
  /**
   * Get the price
   * 
   * @return 	string   The formatted taxfree price
   */
  public function getPrice();
  
  /**
   * Get the price with Tax applied
   * 
   * @return 	string   The formatted taxfull price
   */
  public function getWithTax();
  
  /**
   * Get the amout of tax
   * 
   * @return 	string   The formatted tax price
   */
  public function getVAT();
}
  
