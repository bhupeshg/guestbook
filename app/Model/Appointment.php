<?php

App::uses('AppModel', 'Model');

/**
 *
 */
class Appointment extends AppModel
{
    public $actsAs = array('Containable');

    public $belongsTo = array(
        'Client' => array(
            'className' => 'User',
            'foreignKey' => 'client_id',
            'conditions' => array(),
            'order' => '',
        ),
        'Lawyer' => array(
            'className' => 'User',
            'foreignKey' => 'lawyer_id',
            'conditions' => array(),
            'order' => '',
        ),
    );

    public $validate = array(
        'datetime' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select date and time',
                'last' => true,
            ),
        ),
    );

    /**
     * Function will add appointment to DB.
     *
     * @param [array] $data [data to be stored in DB`]
     *
     * @return [array] sucess, id  [true/false, newly created ID]
     */
    public function add($data)
    {
        if ($data['clientType'] == 'Existing') {
            $data['new_client_name'] = '';
        } else {
            $data['client_id'] = '';
        }
        if ($this->validates()) {
            // Convert datetime format to match db format
            $dateTime = $data['datetime'];
            $dateTime = strtotime($dateTime);
            $dateTime = date('Y-m-d H:i:s', $dateTime);
            $data['datetime'] = $dateTime;
            if ($this->save($data)) {
                return array('success' => true, 'id' => $this->getLastInsertID());
            } else {
                return array('success' => false);
            }
        }
    }

    /**
     * Edit a particular appointment
     * @param  [array] $data [data of appointment being edited]
     * @return [array]  [status of operation as true/false]
     */
    public function edit($data)
    {
        if (!empty($data['clientType'])) {
            if ($data['clientType'] == 'Existing') {
                $data['new_client_name'] = '';
            } else {
                $data['client_id'] = '';
            }
        }

        // Check if request s to update only status or complete record
        if (!empty($data['datetime'])) {
            if ($this->validates()) {
                // Convert datetime format to match db format
            $dateTime = $data['datetime'];
                $dateTime = strtotime($dateTime);
                $dateTime = date('Y-m-d H:i:s', $dateTime);
                $data['datetime'] = $dateTime;
                if ($this->save($data)) {
                    return array('success' => true);
                } else {
                    return array('success' => false);
                }
            }
        } else {
            if ($this->save($data, array('validate' => false))) {
                return array('success' => true);
            } else {
                return array('success' => false);
            }
        }
    }

    public function dateTimeSqlFormat($date)
    {
        if (!empty($date)) {
            $dateArr = explode(' ', $date);
        }

        return $date;
    }
}
