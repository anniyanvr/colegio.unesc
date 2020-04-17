<?php

class block_cocoon_hero_3_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        if (!empty($this->block->config) && is_object($this->block->config)) {
            $data = $this->block->config;
        } else {
            $data = new stdClass();
            $data->slidesnumber = 0;
        }


        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('config_title', 'block_cocoon_hero_3'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', 'MORE THAN 2500 ONLINE COURSES');

        $mform->addElement('text', 'config_subtitle', get_string('config_subtitle', 'block_cocoon_hero_3'));
        $mform->setType('config_subtitle', PARAM_TEXT);
        $mform->setDefault('config_subtitle', 'Own your future learning new skills online');

        $slidesrange = range(0, 12);
        $mform->addElement('select', 'config_slidesnumber', get_string('slides_number', 'block_cocoon_hero_3'), $slidesrange);
        $mform->setDefault('config_slidesnumber', $data->slidesnumber);

        // Feature 1
        $mform->addElement('header', 'config_feature_1', get_string('config_feature_1', 'block_cocoon_hero_3'));

        $mform->addElement('text', 'config_feature_1_title', get_string('config_feature_1_title', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_1_title', 'Design: Over 800 Courses');
        $mform->setType('config_feature_1_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_1_icon', get_string('config_feature_1_icon', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_1_icon', 'flaticon-pencil');
        $mform->setType('config_feature_1_icon', PARAM_TEXT);

        // Feature 2
        $mform->addElement('header', 'config_feature_2', get_string('config_feature_2', 'block_cocoon_hero_3'));

        $mform->addElement('text', 'config_feature_2_title', get_string('config_feature_2_title', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_2_title', 'Business: Over 1,400 Courses');
        $mform->setType('config_feature_2_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_2_icon', get_string('config_feature_2_icon', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_2_icon', 'flaticon-student-1');
        $mform->setType('config_feature_2_icon', PARAM_TEXT);

        // Feature 3
        $mform->addElement('header', 'config_feature_3', get_string('config_feature_3', 'block_cocoon_hero_3'));

        $mform->addElement('text', 'config_feature_3_title', get_string('config_feature_3_title', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_3_title', 'Photography: Over 740 Courses');
        $mform->setType('config_feature_3_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_3_icon', get_string('config_feature_3_icon', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_3_icon', 'flaticon-photo-camera');
        $mform->setType('config_feature_3_icon', PARAM_TEXT);

        // Feature 4
        $mform->addElement('header', 'config_feature_4', get_string('config_feature_4', 'block_cocoon_hero_3'));

        $mform->addElement('text', 'config_feature_4_title', get_string('config_feature_4_title', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_4_title', 'Marketing: Over 200 Courses');
        $mform->setType('config_feature_4_title', PARAM_TEXT);

        $mform->addElement('text', 'config_feature_4_icon', get_string('config_feature_4_icon', 'block_cocoon_hero_3'));
        $mform->setDefault('config_feature_4_icon', 'flaticon-medal');
        $mform->setType('config_feature_4_icon', PARAM_TEXT);

        for($i = 1; $i <= $data->slidesnumber; $i++) {
            $mform->addElement('header', 'config_header' . $i , 'Slide ' . $i);

            $filemanageroptions = array('maxbytes'      => $CFG->maxbytes,
                                        'subdirs'       => 0,
                                        'maxfiles'      => 1,
                                        'accepted_types' => array('.jpg', '.png', '.gif'));

            $f = $mform->addElement('filemanager', 'config_file_slide' . $i, get_string('file_slide', 'block_cocoon_hero_3', $i), null, $filemanageroptions);
        }

    }

    function set_data($defaults) {
        if (!empty($this->block->config) && is_object($this->block->config)) {

            for($i = 1; $i <= $this->block->config->slidesnumber; $i++) {
                $field = 'file_slide' . $i;
                $conffield = 'config_file_slide' . $i;
                $draftitemid = file_get_submitted_draft_itemid($conffield);
                file_prepare_draft_area($draftitemid, $this->block->context->id, 'block_cocoon_hero_3', 'slides', $i, array('subdirs'=>false));
                $defaults->$conffield['itemid'] = $draftitemid;
                $this->block->config->$field = $draftitemid;
            }
        }

        parent::set_data($defaults);
    }
}
