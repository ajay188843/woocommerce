<?php

/**
 * define constant variabes
 * define admin side constant
 * @since 1.0.0
 * @author Multidots
 * @param null
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// define constant for plugin slug
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_SLUG', 'woo-product-recommendation-wizard');
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_NAME', __('Woo Product Recommendation Wizard'));
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN', 'woo-product-recommendation-wizard');
define('WPRW_PLUGIN_VERSION', '1.0.0');
define('WPRW_FREE_PLUGIN', 'Free Version');

####### Wizard Page Constant #######
define('WPRW_LIST_PAGE_TITLE', 'Manage Wizard');
define('WPRW_DELETE_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_WIZARD', 'Add New Wizard');

define('WPRW_WIZARD_TITLE','Wizard Title');
define('WPRW_WIZARD_TITLE_PLACEHOLDER','Enter Wizard Title Here');
define('WPRW_WIZARD_SHORTCODE','Wizard shortcode');
define('WPRW_WIZARD_STATUS','Status');
define('WPRW_WIZARD_TITLE_DESCRIPTION','Wizard title description');
define('WPRW_WIZARD_SHORTCODE_DESCRIPTION','Wizard shortcode description');

####### Question Page Constant #######
define('WPRW_QUESTION_LIST_PAGE_TITLE', 'Manage Question');
define('WPRW_DELETE_QUESTION_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_QUESTION', 'Add New Question');

define('WPRW_WIZARD_QUESTION','Question Title');
define('WPRW_WIZARD_QUESTION_PLACEHOLDER','Enter Question Title Here');
define('WPRW_WIZARD_QUESTION_DESCRIPTION','Question Description Here');
define('WPRW_WIZARD_QUESTION_TYPE','Question Type');
define('WPRW_WIZARD_QUESTION_TYPE_DESCRIPTION','Question description');
define('WPRW_WIZARD_QUESTION_TYPE_RADIO','Radio');
define('WPRW_WIZARD_QUESTION_TYPE_CHECKBOX','Checkbox');

####### Option Page Constant #######
define('WPRW_OPTIONS_LIST_PAGE_TITLE', 'Manage Options');
define('WPRW_DELETE_OPTIONS_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_OPTIONS', 'Add New Options');

define('WPRW_WIZARD_OPTIONS','Options Title');
define('WPRW_WIZARD_OPTIONS_DESCRIPTION','Options Description Here');
define('WPRW_WIZARD_OPTIONS_PLACEHOLDER','Enter Options Title Here');
define('WPRW_WIZARD_OPTIONS_IMAGE','Options Image');
define('WPRW_WIZARD_OPTIONS_UPLOAD_IMAGE','Upload File');
define('WPRW_WIZARD_OPTIONS_REMOVE_IMAGE','Remove File');
define('WPRW_WIZARD_OPTIONS_SELECT_FILE','Select File');
define('WPRW_WIZARD_OPTIONS_IMAGE_DESCRIPTION','Upload Options Image Here');
define('WPRW_WIZARD_ATTRIBUTE_NAME','Attribute Name');
define('WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION','Attribute Description Here');
define('WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER','Select Attribute Name');
define('WPRW_WIZARD_ATTRIBUTE_VALUE','Attribute Value');
define('WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION','Attribute Description Here');
define('WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER','Select Attribute Value');


