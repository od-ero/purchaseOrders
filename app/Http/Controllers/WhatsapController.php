<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService;
class WhatsapController extends Controller
{
    
        protected $whatsapp;
        public function __construct(WhatsAppService $whatsapp)
        {
            $this->whatsapp = $whatsapp;
        }
    
        public function send(Request $request)
        {
            // $request->validate([
            //     'phone' => 'required',
            //     'message' => 'required',
            //     'media_url' => 'required|url',
            // ]);
    
            // $phone = $request->input('phone');
            // $message = $request->input('message');
            // $mediaUrl = $request->input('media_url');
            // $mediaType = $request->input('media_type', 'image'); // Default to image
            // $filename = $request->input('filename', null);
            $mediaUrl = 'https://drive.google.com/file/d/12W257shr6iUYRlLHwP0BX1b4G3vK0xqY/view?usp=sharing';
            $filename = 'Test PNG';
            $mediaType = 'image';
            $message = 'One 2 Test';
            $phone = '+254740203067';
            $result = $this->whatsapp->sendTextMessage($phone, $message);
           // sendMessage($phone, $message, $mediaUrl, $mediaType);
    
            if (isset($result['error']) && $result['error']) {
                return response()->json(['status' => 'Failed to send message', 'error' => $result['message']], 500);
            }
    
            return response()->json(['status' => 'Message sent successfully', 'response' => $result]);
        }

        public function sendWhatsAppMessage(Request $request)
    {
        $recipients = ['+254740203067']; // Add multiple recipients as needed
        $templateName = 'hello_world'; // The template name
        $languageCode = 'en_US'; // Language code
        $pdfUrl = 'https://file-examples.com/storage/fef44df12666d835ba71c24/2017/10/file-sample_150kB.pdf'; // The PDF URL
        $caption = 'Please find your receipt attached.'; // The caption text
        $header = 'Receipt Header'; // The template header text

        $response = $this->whatsapp->sendTemplateMessageWithAttachment($recipients, $templateName, $languageCode, $pdfUrl, $caption, $header);

        if (isset($response['error']) && $response['error']) {
            return response()->json(['status' => 'error', 'message' => $response['message']], 500);
        }

        return response()->json(['status' => 'success', 'response' => $response], 200);
    }
    }