<?php

namespace App\Helpers;

use DateInterval;
use Carbon\Carbon;
use DateTimeImmutable;
use Ddeboer\Imap\Server;
use Ddeboer\Imap\Search\Date\Since;

class ImapManager
{
    public function connectMailbox()
    {
        $imap = getImapConfiguration();
        //$flags = '/imap/ssl/validate-cert';
        $flags = '/imap/ssl/novalidate-cert';

        $server = new Server($imap['host'], $imap['port'], $flags);
        $connection = $server->authenticate(
            $imap['username'],
            $imap['password']
        );

        return $connection;
    }

    public function getMailboxMessages()
    {
        $allowed = explode(',', 'doc,docx,xls,xlsx,ppt,pptx,xps,pdf,dxf,ai,psd,eps,ps,svg,ttf,zip,rar,tar,gzip,mp3,mpeg,wav,ogg,jpeg,jpg,png,gif,bmp,tif,webm,mpeg4,3gpp,mov,avi,mpegs,wmv,flx,txt');
        $connection = $this->connectMailbox();
        $mailbox = $connection->getMailbox('INBOX');
        $today = new DateTimeImmutable();
        $thirtyDaysAgo = $today->sub(new DateInterval('P30D'));
        $messages = $mailbox->getMessages(
            new Since($thirtyDaysAgo),
            \SORTDATE,
            false
        );

        $count = 1;
        $response = [
            'data' => [],
            'notifications' => []
        ];
        foreach ($messages as $message) {
            $blocked = false;
            $sender = $message->getFrom();
            $date = $message->getDate();
            if (!$date) {
                $date = new \DateTime();
                if ($message->getHeaders()->get('udate')) {
                    $date->setTimestamp($message->getHeaders()->get('udate'));
                }
            }
            $datediff = new Carbon($date);
            $content = '';
            $html = $message->getBodyHtml();
            if ($html) {
                $content = str_replace('<a', '<a target="blank"', $html);
            } else {
                $text = $message->getBodyText();
                $content = str_replace('<a', '<a target="blank"', str_replace(array("\r\n", "\n"), '<br/>', $text));
            }
            $obj = [];
            $obj['subject'] = $message->getSubject();
            $obj['sender_name'] = $sender->getName();
            $obj['sender_email'] = $sender->getAddress();
            $obj['timestamp'] = $message->getDate();
            $obj['date'] = $date->format(config('app.settings.date_format', 'd M Y h:i A'));
            $obj['datediff'] = $datediff->diffForHumans();
            $obj['id'] = $message->getNumber();
            $obj['content'] = $content;
            $obj['attachments'] = [];
            if ($message->hasAttachments() && !$blocked) {
                $attachments = $message->getAttachments();
                $directory = './tmp/attachments/' . $obj['id'] . '/';
                is_dir($directory) ?: mkdir($directory, 0777, true);
                foreach ($attachments as $attachment) {
                    $filenameArray = explode('.', $attachment->getFilename());
                    $extension = $filenameArray[count($filenameArray) - 1];
                    if (in_array($extension, $allowed)) {
                        if (!file_exists($directory . $attachment->getFilename())) {
                            file_put_contents(
                                $directory . $attachment->getFilename(),
                                $attachment->getDecodedContent()
                            );
                        }
                        if ($attachment->getFilename() !== 'undefined') {
                            $url = env('APP_URL') . str_replace('./', '/', $directory . $attachment->getFilename());
                            $structure = $attachment->getStructure();
                            if (isset($structure->id) && str_contains($obj['content'], trim($structure->id, '<>'))) {
                                $obj['content'] = str_replace('cid:' . trim($structure->id, '<>'), $url, $obj['content']);
                            }
                            array_push($obj['attachments'], [
                                'file' => $attachment->getFilename(),
                                'url' => $url
                            ]);
                        }
                    }
                }
            }
            array_push($response['data'], $obj);
        }
        $response['data'] = array_reverse($response['data']);
        $connection->expunge();

        return $response;
    }

    public function getMessageById($id)
    {
        $connection = $this->connectMailbox();
        $mailbox    = $connection->getMailbox('INBOX');
        $message    = $mailbox->getMessage($id);

        return $message;
    }

    public function getUsedStorage()
    {
        $connection = $this->connectMailbox();
        $mailbox    = $connection->getMailbox('INBOX');
        $messages   = $mailbox->getMessages();

        $attachmentStorage = 0;
        $bodySize = 0;

        foreach ($messages as $message) {
            $bodySize += number_format($message->getSize() / 1048576, 5);
            $attachments = $message->getAttachments();
            if ($message->hasAttachments()) {
                foreach ($attachments as $attachment) {
                    $byte = $attachment->getStructure()->bytes;
                    $attachmentStorage += number_format($byte / 1048576, 5);
                }
            }
        }

        $storage = $bodySize + $attachmentStorage;
        return $storage;
    }

    public function getMessageDetails($id)
    {
        $allowed = explode(',', 'doc,docx,xls,xlsx,ppt,pptx,xps,pdf,dxf,ai,psd,eps,ps,svg,ttf,zip,rar,tar,gzip,mp3,mpeg,wav,ogg,jpeg,jpg,png,gif,bmp,tif,webm,mpeg4,3gpp,mov,avi,mpegs,wmv,flx,txt');
        $connection = $this->connectMailbox();
        $message = $this->getMessageById($id);

        $response = [
            'data' => []
        ];
        $blocked = false;
        $sender = $message->getFrom();
        $date = $message->getDate();
        if (!$date) {
            $date = new \DateTime();
            if ($message->getHeaders()->get('udate')) {
                $date->setTimestamp($message->getHeaders()->get('udate'));
            }
        }
        $datediff = new Carbon($date);
        $content = '';
        $html = $message->getBodyHtml();
        if ($html) {
            $content = str_replace('<a', '<a target="blank"', $html);
        } else {
            $text = $message->getBodyText();
            $content = str_replace('<a', '<a target="blank"', str_replace(array("\r\n", "\n"), '<br/>', $text));
        }
        $obj = [];
        $obj['subject'] = $message->getSubject();
        $obj['sender_name'] = $sender->getName();
        $obj['sender_email'] = $sender->getAddress();
        $obj['timestamp'] = $message->getDate();
        $obj['date'] = $date->format(config('app.settings.date_format', 'd M Y h:i A'));
        $obj['datediff'] = $datediff->diffForHumans();
        $obj['id'] = $message->getNumber();
        $obj['content'] = $content;
        $obj['attachments'] = [];
        if ($message->hasAttachments() && !$blocked) {
            $attachments = $message->getAttachments();
            $directory = './tmp/attachments/' . $obj['id'] . '/';
            is_dir($directory) ?: mkdir($directory, 0777, true);
            foreach ($attachments as $attachment) {
                $filenameArray = explode('.', $attachment->getFilename());
                $extension = $filenameArray[count($filenameArray) - 1];
                if (in_array($extension, $allowed)) {
                    if (!file_exists($directory . $attachment->getFilename())) {
                        file_put_contents(
                            $directory . $attachment->getFilename(),
                            $attachment->getDecodedContent()
                        );
                    }
                    if ($attachment->getFilename() !== 'undefined') {
                        $url = env('APP_URL') . str_replace('./', '/', $directory . $attachment->getFilename());
                        $structure = $attachment->getStructure();
                        if (isset($structure->id) && str_contains($obj['content'], trim($structure->id, '<>'))) {
                            $obj['content'] = str_replace('cid:' . trim($structure->id, '<>'), $url, $obj['content']);
                        }
                        array_push($obj['attachments'], [
                            'file' => $attachment->getFilename(),
                            'url' => $url
                        ]);
                    }
                }
            }
        }

        array_push($response['data'], $obj);

        $response['data'] = array_reverse($response['data']);
        $connection->expunge();

        return $response;
    }
}
