<?php namespace InvoiceNinja\Models;

use stdClass;

class Client extends AbstractModel
{
    public static $route = 'clients';
    public $contacts = [];

    public function __construct($email = '', $first_name = '', $last_name = '', $name = '')
    {
        $this->name = $name;
        $this->addContact($email, $first_name, $last_name);
    }

    public static function findByClientEmail($email)
    {
        $url = sprintf('%s?email=%s', static::getRoute(), $email);
        $data = static::sendRequest($url);

        $result = [];
        foreach ($data as $item) {
            $result[] = static::hydrate($item);
        }

        return $result;
    }

    public function addContact($email = '', $first_name = '', $last_name = '')
    {
        $contact = new stdClass();
        $contact->email = $email;
        $contact->first_name = $first_name;
        $contact->last_name = $last_name;

        $this->contacts[] = $contact;
    }

    public function createInvoice()
    {
        $invoice = new Invoice();
        $invoice->client_id = $this->id;

        return $invoice;
    }
}
