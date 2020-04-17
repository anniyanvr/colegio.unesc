<?php

class block_cocoon_contact_form_edit_form extends block_edit_form
{
    protected function specific_definition($mform)
    {
      global $CFG;

        // Feature 1
        $mform->addElement('header', 'config_header_1', 'Feature 1');

        $mform->addElement('text', 'config_feature_1_title', get_string('config_feature_1_title', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_1_title', 'Our Location');
        $mform->setType('config_feature_1_title', PARAM_RAW);

        $mform->addElement('text', 'config_feature_1_subtitle', get_string('config_feature_1_subtitle', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_1_subtitle', 'Collin Street West, Victor 8007, Australia.');
        $mform->setType('config_feature_1_subtitle', PARAM_RAW);

        $mform->addElement('text', 'config_feature_1_icon', get_string('config_feature_1_icon', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_1_icon', 'flaticon-placeholder-1');
        $mform->setType('config_feature_1_icon', PARAM_RAW);

        // Feature 2
        $mform->addElement('header', 'config_header_2', 'Feature 2');

        $mform->addElement('text', 'config_feature_2_title', get_string('config_feature_2_title', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_2_title', 'Our Numbers');
        $mform->setType('config_feature_2_title', PARAM_RAW);

        $mform->addElement('text', 'config_feature_2_subtitle', get_string('config_feature_2_subtitle', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_2_subtitle', 'Mobile: (+096) 468 235');
        $mform->setType('config_feature_2_subtitle', PARAM_RAW);

        $mform->addElement('text', 'config_feature_2_icon', get_string('config_feature_2_icon', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_2_icon', 'flaticon-phone-call');
        $mform->setType('config_feature_2_icon', PARAM_RAW);

        // Feature 3
        $mform->addElement('header', 'config_header_3', 'Feature 3');

        $mform->addElement('text', 'config_feature_3_title', get_string('config_feature_3_title', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_3_title', 'Our Email');
        $mform->setType('config_feature_3_title', PARAM_RAW);

        $mform->addElement('text', 'config_feature_3_subtitle', get_string('config_feature_3_subtitle', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_3_subtitle', 'info@edumy.com');
        $mform->setType('config_feature_3_subtitle', PARAM_RAW);

        $mform->addElement('text', 'config_feature_3_icon', get_string('config_feature_3_icon', 'block_cocoon_contact_form'));
        $mform->setDefault('config_feature_3_icon', 'flaticon-email');
        $mform->setType('config_feature_3_icon', PARAM_RAW);

        // Contact Form
        $mform->addElement('header', 'config_header_4', 'Contact form');

        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_contact_form'));
        $mform->setDefault('config_title', 'Send a Message');
        $mform->setType('config_title', PARAM_RAW);

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_contact_form'));
        $mform->setDefault('config_subtitle', 'Ex quem dicta delicata usu, zril vocibus maiestatis in qui.');
        $mform->setType('config_subtitle', PARAM_RAW);

        // Google Map
        $mform->addElement('header', 'config_header_5', 'Google map');

        $mform->addElement('text', 'config_map_lat', get_string('config_map_lat', 'block_cocoon_contact_form'));
        $mform->setDefault('config_map_lat', '40.6946703');
        $mform->setType('config_map_lat', PARAM_RAW);

        $mform->addElement('text', 'config_map_lng', get_string('config_map_lng', 'block_cocoon_contact_form'));
        $mform->setDefault('config_map_lng', '-73.9280182');
        $mform->setType('config_map_lng', PARAM_RAW);

        // Image
        $mform->addElement('filemanager', 'config_image', get_string('config_image', 'block_cocoon_contact_form'), null,
                array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,
                'accepted_types' => array('.png', '.jpg', '.gif') ));


    }

    function set_data($defaults)
    {

        // Begin CCN Image Processing
        if (empty($entry->id)) {
            $entry = new stdClass;
            $entry->id = null;
        }
        $draftitemid = file_get_submitted_draft_itemid('config_image');
        file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_contact_form', 'content', 0,
            array('subdirs' => true));
        $entry->attachments = $draftitemid;
        parent::set_data($defaults);
        if ($data = parent::get_data()) {
            file_save_draft_area_files($data->config_image, $this->block->context->id, 'block_cocoon_contact_form', 'content', 0,
                array('subdirs' => true));
        }
        // END CCN Image Processing



        if (!empty($this->block->config) && is_object($this->block->config)) {
            $text = $this->block->config->bio;
            $draftid_editor = file_get_submitted_draft_itemid('config_bio');
            if (empty($text)) {
                $currenttext = '';
            } else {
                $currenttext = $text;
            }
            $defaults->config_bio['text'] = file_prepare_draft_area($draftid_editor, $this->block->context->id, 'block_cocoon_contact_form', 'content', 0, array('subdirs'=>true), $currenttext);
            $defaults->config_bio['itemid'] = $draftid_editor;
            $defaults->config_bio['format'] = $this->block->config->format;
        } else {
            $text = '';
        }


    }
}
