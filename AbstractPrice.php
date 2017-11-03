<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Price;

/**
 * Price Base Class
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
abstract class AbstractPrice implements PriceInterface
{
	/**
	 * Price VAT rate
   * 
	 * @var    float 
   */
  protected $taxRate;
  
	/**
	 * Price number of decimals
   * 
	 * @var    int 
   */
  protected $decimals;
  
	/**
	 * Price decimals separator
   * 
	 * @var    string 
   */
  protected $decimalsSeparator;
  
	/**
	 * Price thousands separator
   * 
	 * @var    string 
   */
  protected $thousandsSeparator;
  
	/**
	 * Price value
   * 
	 * @var    float
   */
  protected $price;
  
	/**
	 * Hide cents when displaying the price
   * 
	 * @var    bool
   */
	protected $hideCents;
  
	/**
	 * Hide cents only when 0
   * 
	 * @var    bool
   */
	protected $hideCentsWhenEmpty;
  
	/**
	 * Hide the currency when displaying the price
   * 
	 * @var    bool
   */
	protected $hideCurrency;
  
	/**
	 * Price currency
   * 
	 * @var    string
   */
  protected $currency;
  
	/**
	 * Hide the suffix when displaying the price
   * 
	 * @var    bool
   */
	protected $hideSuffix;
  
	/**
	 * Taxfree suffix
   * 
	 * @var    bool
   */
  protected $taxFreeSuffix;
  
	/**
	 * Not taxfree suffix
   * 
	 * @var    bool
   */
  protected $taxFullSuffix;
  
  /**
   * Constructor
   * 
   * @param 	mixed   $price      The price
   * @param 	array   $taxFree    True if the price is taxfree.
   *                              If tax is included, the base price will be calculted 
   *                              according to the specified taxRate.
   */
  public function __construct($price, $taxFree=true)
  {
    // @todo : clean price
    
    if ( $taxFree === false ){
      $price = ($price * $this->taxRate) / 100;
    }
    
    $this->price = $price;
    
    if ( !isset($this->hideCents) ){
      $this->hideCents = false;
    }
    if ( !isset($this->hideCentsWhenEmpty) ){
      $this->hideCentsWhenEmpty = false;
    }
    if ( !isset($this->hideCurrency) ){
      $this->hideCurrency = false;
    }
    if ( !isset($this->hideSuffix) ){
      $this->hideSuffix = false;
    }
    if ( !isset($this->currency) ){
      $this->currency = '';
    }
    if ( !isset($this->taxFreeSuffix) ){
      $this->taxFreeSuffix = '';
    }
    if ( !isset($this->taxFullSuffix) ){
      $this->taxFullSuffix = '';
    }
    
    if ( $this->decimals === 0 ){
      $this->hideCents = true;
    }
    
    if ( $this->currency === '' ){
      $this->hideCurrency = true;
    }
    
    if ( $this->taxFreeSuffix === '' && $this->taxFullSuffix === '' ){
      $this->hideSuffix = true;
    }
  }
  
  /**
   * {@inheritDoc}
   */
  public function config(array $config=[])
  {
    if ( isset($config['hideCents']) ){
      $this->hideCents = (bool)$config['hideCents'];
    }
    if ( isset($config['hideCentsWhenEmpty']) ){
      $this->hideCentsWhenEmpty = (bool)$config['hideCentsWhenEmpty'];
    }
    if ( isset($config['hideCurrency']) ){
      $this->hideCurrency = (bool)$config['hideCurrency'];
    }
    if ( isset($config['hideSuffix']) ){
      $this->hideSuffix = (bool)$config['hideSuffix'];
    }
    return $this;
  }
  
  /**
   * {@inheritDoc}
   */
  public function getPrice()
  {
    $price = $this->price;
    $price = $this->format($price);
    
    if ( $this->hideSuffix === false && $this->taxFreeSuffix !== '' ){
      $price .= ' '.$this->taxFreeSuffix;
    }
    
    return $price;
  }
  
  /**
   * {@inheritDoc}
   */
  public function getWithTax()
  {
    $price = $this->price * (1 + $this->taxRate);
    $price = $this->format($price);
    
    if ( $this->hideSuffix === false && $this->taxFullSuffix !== '' ){
      $price .= ' '.$this->taxFullSuffix;
    }
    
    return $price;
  }
  
  /**
   * {@inheritDoc}
   */
  public function getVAT()
  {
    $price = $this->price * $this->taxRate;
    $price = $this->format($price);
    return $price;
  }
  
  /**
   * Format the price according to the config
   * 
   * @param   mixed     Price
   * @return 	string    The formatted price
   */
  protected function format($price)
  {
    if ( $this->hideCents === false && $this->decimals > 0 ){
      $price = number_format($price, $this->decimals, $this->decimalsSeparator, $this->thousandsSeparator);
      if ( $this->hideCentsWhenEmpty === true ){
        list($_price, $cents) = explode($this->decimalsSeparator, $price);
        if ( $cents === '00' ){
          $price = $_price;
        }
      }
    }
    else {
      // @todo: round()??
      $price = number_format($price, 0, $this->decimalsSeparator, $this->thousandsSeparator);
    }
    
    if ( $this->hideCurrency === false && $this->currency !== '' ){
      $price .= ' '.$this->currency;
    }
    
    return $price;
  }
}
  
