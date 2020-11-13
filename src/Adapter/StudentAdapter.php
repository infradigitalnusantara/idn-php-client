<?php
namespace InfraDigital\ApiClient\Adapter;

class StudentAdapter extends BaseAdapter
{
    private $studentsData       = array();
    private $billComponentData  = array();
    private $billData           = array();

    public function createStudent($name, $billKeyValue, $phone = '', $email = '', $description = '')
    {
        $this->studentsData[] = array(
            'name'              => $name,
            'bill_key_value'    => $billKeyValue,
            'phone'             => $phone,
            'email'             => $email,
            'description'       => $description,
        );

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill',
            array(),
            $this->getMainEntity()->isDevMode()
        );
        $this->httpPost($uri, array(), $this->studentsData[0]);

        return $this;
    }

    public function appendStudentData($name, $billKeyValue, $phone = '', $email = '', $description = '')
    {
        $this->studentsData[] = array(
            'name'              => $name,
            'bill_key_value'    => $billKeyValue,
            'phone'             => $phone,
            'email'             => $email,
            'description'       => $description,
        );

        return $this;
    }

    public function createStudents(array $studentsData = array())
    {
        if ( ! empty($studentsData)) {
            foreach ($studentsData as $student) {
                $this->studentsData[] = array(
                    'name'              => $student['name'],
                    'bill_key_value'    => $student['billKeyValue'],
                    'phone'             => $student['phone'],
                    'email'             => $student['email'],
                    'description'       => $student['description'],
                );
            }
        }

        if (empty($this->studentsData)) {
            return false;
        }

        $content = array(
            'bill_list' => $this->studentsData,
        );

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill/batch',
            array(),
            $this->getMainEntity()->isDevMode()
        );
        $this->httpPost($uri, array(), $content);

        return $this;
    }

    public function updateStudent($name, $billKeyValue, $phone = '', $email = '', $description = '')
    {
        $this->studentsData = array(
            array(
                'name'              => $name,
                'bill_key_value'    => $billKeyValue,
                'phone'             => $phone,
                'email'             => $email,
                'description'       => $description,
            )
        );

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill',
            array(),
            $this->getMainEntity()->isDevMode()
        );
        $this->httpPut($uri, array(), $this->studentsData[0]);

        return $this;
    }

    public function deleteStudent($billKeyValue)
    {
        if ($billKeyValue == "") {
            return $this;
        }

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill/' . $billKeyValue,
            array(),
            $this->getMainEntity()->isDevMode()
        );
        $this->httpDel($uri, array());

        return $this;
    }

    public function appendBillComponentData($billKey, $accountCode, $billComponentName, $amount, $expiryDate, $dueDate, $activeDate = '', $penaltyAmount  = 0, $notes = '')
    {
        $this->billComponentData[] = array(
            'bill_key' => $billKey,
            'account_code' => $accountCode,
            'bill_component_name' => $billComponentName,
            'expiry_date' => $this->convertDatetimeToIso($expiryDate),
            'due_date' => $this->convertDatetimeToIso($dueDate),
            'amount' => $amount,
            'active_date' => $this->convertDatetimeToIso($activeDate),
            'penalty_amount' => $penaltyAmount,
            'notes' => $notes,
        );

        return $this;
    }

    public function addBillComponents($billComponents = array())
    {
        if ( ! empty($billComponents)) {
            $this->billComponentData = $billComponents;
        }

        if (empty($this->billComponentData)) {
            return false;
        }

        $content = array(
            'bill_upload_list' => $this->billComponentData,
        );
        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill_component/batch',
            array(),
            $this->getMainEntity()->isDevMode()
        );

        $this->httpPost($uri, array(), $content);

        return $this;
    }

    public function getStudents($name = '', $billKey = '', $offset = 0, $limit = 0)
    {
        $query = array();
        if ($name != '') {
            $query['name'] = $name;
        }
        if ($billKey != '') {
            $query['bill_key'] = $billKey;
        }
        if ($offset != '') {
            $query['offset'] = $offset;
        }
        if ($limit != '') {
            $query['limit'] = $limit;
        }

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill',
            $query,
            $this->getMainEntity()->isDevMode()
        );
        $this->httpGet($uri, array());

        return $this;
    }

    public function getBills($query = array())
    {
        if (isset($query['bill_key'])) {
            return $this->getStudentBills($query["bill_key"], $query);
        }
        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill_component/search/biller',
            $query,
            $this->getMainEntity()->isDevMode()
        );
        $this->httpGet($uri, array());

        return $this;
    }

    public function getStudentBills($nis, $query = array())
    {
        $query['bill_key'] = $nis;

        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill_component/search/bill',
            $query,
            $this->getMainEntity()->isDevMode()
        );
        $this->httpGet($uri, array());

        return $this;
    }

    public function createBill($name, $billKeyValue, $phone, $email, $description, $billUploadList = array())
    {
        $content = array(
            'name'              => $name,
            'bill_key_value'    => $billKeyValue,
            'phone'             => $phone,
            'email'             => $email,
            'description'       => $description,
            'bill_upload_list'  => $billUploadList,
        );
        $uri = $this->getUtils()->buildUri(
            $this->getMainEntity()->getUsername(),
            $this->getMainEntity()->getPassword(),
            'bill/checkout',
            array(),
            $this->getMainEntity()->isDevMode()
        );
        $this->httpPost($uri, array(), $content);

        return $this;
    }
}