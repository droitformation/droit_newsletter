<?php namespace App\Droit\Newsletter\Worker;

use App\Droit\Newsletter\Worker\MailjetInterface;
use App\Droit\Newsletter\Service\Mailjet;

class MailjetWorker implements MailjetInterface{

    protected $mailjet;
    protected $sender = 'info@droitne.ch';
    protected $list   = '1499252'; // Testing list if we want another just passe it via the constructor

    public function __construct(Mailjet $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /*
     * Set the ID of list
    */
    public function setList($list)
    {
        $this->list = $list;
    }

    /*
     * Set the ID of list
    */
    public function setSenderEmail($email)
    {
        $this->sender = $email;
    }

    public function getList()
    {
        return $this->list;
    }

    /**
     * get Subscribers
     * Return data json
     *
     * {
     *      "Count" : 1,
     *      "Data"  : [{
     *          "Address"         : "g1mmsov99",
     *          "CreatedAt"       : "2015-10-06T07:48:54Z",
     *          "ID"              : 1499252,
     *          "IsDeleted"       : false,
     *          "Name"            : "Testing",
     *          "SubscriberCount" : 3
     *      }],
     *      "Total" : 1
     *  }
     *
     */
    public function getSubscribers(){

        $params = array(
            "method" => "VIEW",
            "ID"     => $this->list
        );

        $result = $this->mailjet->contactslist($params);

        if ($this->mailjet->getResponseCode() == 200)
            return $result;
        else
            return $this->mailjet->getResponseCode();

    }

    /*
     * {
     *   "Count" : 4,
     *   "Data"  :
     *    [
     *      {
     *        "CreatedAt" : "2015-10-06T07:22:47Z",
     *        "DeliveredCount" : 0,
     *        "Email" : "droitformation@droitne.ch",
     *        "ID" : 1524810482,
     *        "IsOptInPending" : false,
     *        "IsSpamComplaining" : false,
     *        "LastActivityAt" : "2015-10-06T07:22:47Z",
     *        "LastUpdateAt" : "",
     *        "Name" : "",
     *        "UnsubscribedAt" : "",
     *        "UnsubscribedBy" : ""
     *      },
     *      {
     *        "CreatedAt" : "2015-10-06T07:48:59Z",
     *        "DeliveredCount" : 0,
     *        "Email" : "cindy.leschaud@gmail.com",
     *        "ID" : 1524902722,
     *        "IsOptInPending" : false,
     *        "IsSpamComplaining" : false,
     *        "LastActivityAt" : "2015-10-06T07:48:59Z",
     *        "LastUpdateAt" : "2015-10-06T07:48:59Z",
     *        "Name" : "",
     *        "UnsubscribedAt" : "",
     *        "UnsubscribedBy" : ""
     *      }
     *   ],
     *   "Total" : 4
     * }
     *
    */
    public function getAllSubscribers()
    {
        # Parameters
        $params = array(
            "method"       => "LIST",
            "ContactsList" => $this->list
        );

        # Call
        $response = $this->mailjet->contact($params);

        return $response;
    }

    /**
     * add new contact
     */
    public function addContact($email){

        $params = array(
            'method' => 'POST',
            'Email'  => $email
        );

        $result = $this->mailjet->contact($params);

        if ($this->mailjet->getResponseCode() == 200)
            return $result->Data[0]->ID;
        else
            return $this->getContactByEmail($email);

    }

    public function getContactByEmail($contactEmail) {

        $params = array(
            "method" => "VIEW",
            "ID"     => $contactEmail
        );

        $result = $this->mailjet->contact($params);

        return ($this->mailjet->getResponseCode() == 200 ? $result->Data[0]->ID : $result);
    }

    public function addContactToList($contactID) {

        $params = array(
            "method"    => "POST",
            "ContactID" => $contactID,
            "ListID"    => $this->list,
            "IsActive"  => "True"
        );

        $result = $this->mailjet->listrecipient($params);

        return ($this->mailjet->getResponseCode() == 201 ? $result : false);

    }

    public function subscribeEmailToList($email)
    {
        // Add contact to our list and get id back
        $contactID = $this->addContact($email);

        // Attempt tu subscribe if fails we try to re subscribe
        $result = $this->addContactToList($contactID);

        return ($this->mailjet->getResponseCode() == 201 ? $result : false);
    }

    /**
     * remove contact
     */
    public function removeContact($email){

        $listRecipientID = $this->getListRecipient($email);

        if(!$listRecipientID){
            return false;
        }

        $params = array(
            "method" => "DELETE",
            "ID"     => $listRecipientID
        );

        $this->mailjet->listrecipient($params);

        if (($this->mailjet->getResponseCode() == 200) || ($this->mailjet->getResponseCode() == 202) || ($this->mailjet->getResponseCode() == 204))
            return true;
        else
            return false;

    }

    public function getListRecipient($email){

        $params = array(
            "method"        => "GET",
            "ContactsList"  => $this->list,
            "ContactEmail"  => $email,
        );

        $listerecipient = $this->mailjet->listrecipient($params);

        if ($this->mailjet->getResponseCode() == 200 && isset($listerecipient->Data[0]))
            return $listerecipient->Data[0]->ID;
        else
            return false;

    }

    public function getCampagne($CampaignID){

        # Parameters
        $params = array( "method" => "VIEW" , 'unique' => 'mj.nl='.$CampaignID);

        # Call
        $response = $this->mailjet->campaign($params);

        return ($response ? $response : false);
    }

    /**
     * create new campagne
     */
    public function createCampagne($campagne){

        # Parameters
        $params = array(
            'method'         => 'POST',
            'Title'          => $campagne->newsletter->titre,
            'Subject'        => $campagne->sujet,
            'ContactsListID' => $this->list,
            'Locale'         => 'fr',
            'Callback'       => url('/api'),
            'HeaderLink'     => url('/'),
            'SenderEmail'    => $this->sender,
            'Sender'         => $campagne->newsletter->from_name
        );

        # Call
        $response = $this->mailjet->newsletter($params);

        if($response)
        {
            $campagne->api_campagne_id = $response->Data[0]->ID;
            $campagne->save();

            return true;
        }
    }

    public function setHtml($html,$id){

        # Parameters
        $params = array(
            'method'        => 'PUT',
            '_newsletter_id' => $id,
            'html_content'  => $html,
        );

        # Call
        $response = $this->mailjet->addHTMLbody($params);

        return ($response ? $response : false);

    }


    public function sendTest($email,$html,$sujet){

        $params = array(
            "method"  => "POST",
            "from"    => $this->sender,
            "to"      => $email,
            "subject" => $sujet,
            "html"    => $html
        );

        $result = $this->mailjet->sendEmail($params);

        if ($this->mailjet->getResponseCode() == 200)
            return $result;
        else
            return $result;

    }

    public function sendCampagne($id,$CampaignID){

        $params = array(
            "method"     => "POST",
            "Status"     => "upload",
            "unique"     => 'camp_'.$CampaignID,
            "JobType"    => "Send newsletter",
            "RefID"      => $id
        );

        $result = $this->mailjet->batchjob($params);

        if ($this->mailjet->getResponseCode() == 201)
            return true;
        else
            return $result;

    }

    public function statsCampagne($id){

        # Parameters
        $params = array( "method" => "VIEW" , 'unique' => 'mj.nl='.$id);

        # Call
        $response = $this->mailjet->campaignstatistics($params);

        return $response;

    }


    public function statsAllCampagne(){

        # Parameters
        $params = array( "method" => "VIEW");

        # Call
        $response = $this->mailjet->campaignstatistics($params);

        return $response;

    }

    public function statsListe(){

        # Parameters
        $params = array( "method" => "GET", 'ListRecipientID' => $this->list );

        # Call
        $response = $this->mailjet->listrecipientstatistics($params);

        return ($response ? $response : false);

    }

    public function campagneAggregate($id){

        # Parameters
        $params = array( "method" => "LIST", 'CampaignID' => $id );

        # Call
        $response = $this->mailjet->clickstatistics($params);

        return ($response ? $response : false);

    }


    public function clickStatistics($id, $offset = 0){

        # Parameters
        $params = array("method" => "GET", 'CampaignID' => $id ,'Limit' => 500, 'Offset' => $offset);

        # Call
        $response = $this->mailjet->clickstatistics($params);

        return ($response ? $response : false);

    }


    public function openStats($campaignID){

        $params = array(
            "method"     => "GET",
            "CampaignID" => $campaignID,
            'Limit' => 1000,
            'Offset' => 200
        );

        $response = $this->mailjet->openinformation ($params);

        return ($response ? $response : false);
    }
}
