<?php
/**
 * ECascadeDropDown.php
 *
 * Create dependent dropdownlists with the help of jQuery plugin jquery-cascade
 * @link http://code.google.com/p/jquery-cascade/
 *
 *
 * @author Joe Blocher <yii@myticket.at>
 * @copyright 2012 myticket it-solutions gmbh
 * @license New BSD License
 * @category User Interface
 * @version 1.0
 */
class ECascadeDropDown
{
    /**
     * Internal used vars
     */
    protected static $_instance;

    private $_masterId;

    private $_actionRoute;

    private $_actionParams;

    /**
     * The constructor
     *
     * @param $masterId
     * @param null $actionRoute
     */
    public function __construct($masterId, $actionRoute = null, $actionParams = array())
    {
        $this->setMasterId($masterId);
        $this->setActionRoute($actionRoute);
        $this->setActionParams($actionParams);
        $this->registerClientScript();
    }

    /**
     * Create an instance and assign the masterId (and the actionRoute)
     *
     * @param $masterId the id of the master dropdownlist
     * @param mixed $actionRoute the url for the ajax data-request: used for Yii::app()->createUrl
     * @param array $actionParams the params for the url
     * @return ECascadeDropDown
     */
    public static function master($masterId, $actionRoute = null, $actionParams = array())
    {
        if (!isset(self::$_instance))
            self::$_instance = new ECascadeDropDown($masterId, $actionRoute, $actionParams);
        else
        {
            self::$_instance->setMasterId($masterId);
            self::$_instance->setActionRoute($actionRoute);
            self::$_instance->setActionParams($actionParams);
        }

        return self::$_instance;
    }

    /**
     * Get the masterId
     *
     * @return string
     */
    public function getMasterId()
    {
        return $this->_masterId;
    }

    /**
     * Set the masterId
     *
     * @param $masterId
     */
    public function setMasterId($masterId)
    {
        $this->_masterId = $masterId;
    }

    /**
     * Set the actionRoute of the master dropdown
     *
     * @param string $actionRoute
     */
    public function setActionRoute($actionRoute)
    {
        $this->_actionRoute = $actionRoute;
    }

    /**
     * Get the actionRoute of the master dropdown
     *
     * @return string
     */
    public function getActionRoute()
    {
        return $this->_actionRoute;
    }

    /**
     * Set the action params for the action route
     *
     * @param array $actionParams
     */
    public function setActionParams($actionParams)
    {
        $this->_actionParams = $actionParams;
    }

    /**
     * Get the action params of the action route
     *
     * @return array
     */
    public function getActionParams()
    {
        return $this->_actionParams;
    }

    /**
     * Register the js-files
     */
    protected function registerClientScript()
    {
        $assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($assets);

        $js = $baseUrl . '/jquery.cascade-select.js';
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile($js);
    }

    /**
     * Assign the dependent dropdownlist
     *
     * @param $id the id of the dropdownlist
     * @param array $options of the jquery-cascade plugin - see defaults in the js-code:
     *
     *            sourceStartingLabel: "Select one first",
     *            dependentNothingFoundLabel: "No elements found",
     *            dependentStartingLabel: "Select one",
     *            dependentLoadingLabel: "Loading options",
     *            disableUntilLoaded: true,
     *            spinnerClass: "cascading-select-spinner",
     *            extraParams: {}
     *
     * @param string $actionRoute the route (controllerid/action) where to get the listdata.
     *              Override from master. Used for Yii::app()->createUrl.
     * @param array $actionParams the params for the action route. Override from master.
     * @param bool $jsDirectOutput if used in a ajax enviroment, direct script output if true
     * @param int $position of the registered script
     * @return mixed
     */
    public function setDependent($id, $options = array(), $actionRoute = null, $actionParams = array(), $jsDirectOutput = false, $position = CClientScript::POS_READY)
    {
        $extraParams = isset($options['extraParams']) ? $options['extraParams'] : array();
        $extraParams['masterId'] = $this->_masterId;
        $extraParams['dependentId'] = $id;
        $options['extraParams'] = $extraParams;

        if (!isset($actionRoute))
        {
            $actionRoute = $this->getActionRoute();
            $actionParams = $this->getActionParams();
        }

        $options = array_merge(array(
            'source' => Yii::app()->createUrl($actionRoute, $actionParams),
            'cascaded' => $id
        ), $options);

        $jsOptions = CJavaScript::encode($options);
        $jsCode = "jQuery('#" . $this->_masterId . "').cascade($jsOptions);";

        if ($jsDirectOutput)
            echo CHtml::script($jsCode);
        else
            Yii::app()->clientScript->registerScript('JQCascadeDropDown#' . $this->_masterId, $jsCode, $position);

        self::$_instance->setMasterId($id);
        return self::$_instance;
    }

    /**
     * Converts and encodes a assoziative array as data response
     * Used in the controller action
     *
     * @param $items
     */
    public static function renderArrayData($items, $prompt = 'Selecione...')
    {
        if (is_array($items))
        {
            $data = array();
            if (!empty($prompt))
                $data[] = array('value' => '', 'label' => $prompt);

            foreach ($items as $key => $value)
                $data[] = array('value' => $key, 'label' => $value);

            echo CJSON::encode($data);

            Yii::app()->end();
        }
    }

    /**
     * Converts and encodes a assoziative array as data response
     * Used in the controller action
     *
     * @param $items
     */
    public static function renderEmptyData($value = 'Nenhum resultado encontrado')
    {
        $data = array();
        $data[] = array('value' => '', 'label' => $value);
        echo CJSON::encode($data);

        Yii::app()->end();
    }

    /**
     * Generates the data suitable for list-based HTML elements as data response
     * Used in the controller action
     *
     * @param $models
     * @param $valueField
     * @param $textField
     * @param string $groupField
     */
    public static function renderListData($models, $valueField, $textField, $groupField = '', $prompt = 'Selecione...')
    {
        self::renderArrayData(CHtml::listData($models, $valueField, $textField, $groupField, $prompt));
    }

    /**
     * Get the submitted key from the master dropdown
     * Used in the controller action
     *
     * @return string
     */
    public static function submittedKeyValue()
    {
        return self::submittedParam('selected');
    }

    /**
     * Get the submitted id from the master dropdown
     * Used in the controller action
     *
     * @return string
     */
    public static function submittedMasterId()
    {
        return self::submittedParam('masterId');
    }

    /**
     * Get the submitted id from the dependent dropdown
     * Used in the controller action
     *
     * @return string
     */
    public static function submittedDependentId()
    {
        return self::submittedParam('dependentId');
    }

    /**
     * Get a submitted custom param from the master dropdown
     * Used in the controller action
     *
     * @return string
     */
    public static function submittedParam($name)
    {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }

    /*
     * Check if this is a valid request from the master dropdown
     * Used in the controller action
     *
     */
    public static function checkValidRequest()
    {
        $result = Yii::app()->request->isAjaxRequest &&
            self::submittedMasterId() !== null &&
            self::submittedDependentId() !== null &&
            self::submittedParam('timestamp') !== null;

        if (!$result)
            Yii::app()->end();
    }
}
