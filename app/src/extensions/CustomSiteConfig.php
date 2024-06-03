<?php
namespace App\Extension;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField; 
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
    
class CustomSiteConfig extends Extension {
    
    private static $db = array(
        'FooterText'        => 'Text',
        'LogoLink'          => 'Text',
        'LogoURL'           => 'Text',
        'GoogleAnalytics'   => 'Text',
        'FbAppId'           => 'Text',
        'FacebookLink'      => 'Text',
        'TwitterLink'       => 'Text',
        'TwName'            => 'Text',
        'TwCreator'         => 'Text',
        'GoogleLink'        => 'Text',
        'InstagramLink'     => 'Text',
        'YoutubeLink'       => 'Text',
        'TikTokLink'        => 'Text',
        'TwitchLink'        => 'Text',
        'SpotifyLink'       => 'Text',
        'TelegramLink'      => 'Text',
        'GoogleNewsLink'    => 'Text',
        'LinkedinLink'      => 'Text',
        'FlipboardLink'     => 'Text',
        'PinterestLink'     => 'Text'
    );

    private static $has_one = array(
        'HeaderLogo' => Image::class,
        'FooterLogo' => Image::class,
        'Copertina'  => Image::class
    );

    private static $owns = [
        'HeaderLogo',
        'FooterLogo',
        'Copertina',
    ];

    public function updateCMSFields(FieldList $fields) {
        // Image Field
        $fields->addFieldToTab("Root.Logo", TextField::create('LogoLink', 'Link del Logo'));
        $fields->addFieldToTab("Root.Logo", TextField::create('LogoURL', 'URL del Logo svg'));
        $fields->addFieldToTab('Root.Logo', UploadField::create('HeaderLogo'),'');
        $fields->addFieldToTab('Root.Logo', UploadField::create('FooterLogo'),''); 
        // Copertina Magazine Footer
        $fields->addFieldToTab('Root.Copertina', UploadField::create('Copertina'),''); 
        // Footer
        $fields->addFieldToTab("Root.Footer", TextField::create('FooterText', 'Testo nel footer'));
        // Google
        $fields->addFieldToTab("Root.Google", TextField::create('GoogleAnalytics', 'Google Gtm Code'));
        // Footer Social
        $fields->addFieldToTab('Root.Social', TextField::create('FbAppId','Facebook App ID'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('FacebookLink','Facebook Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('TwitterLink','Twitter Link'),'');
        $fields->addFieldToTab('Root.Social', TextField::create('TwName','Twitter Nickname'),'');
        $fields->addFieldToTab('Root.Social', TextField::create('TwCreator','Twitter Creator (creator is the same as the nickname)'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('GoogleLink','Google Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('InstagramLink','Instagram Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('YoutubeLink','Youtube Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('TikTokLink','TikTok Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('PinterestLink','Pinterest Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('TwitchLink','Twitch Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('SpotifyLink','Spotify Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('TelegramLink','Telegram Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('GoogleNewsLink','Google News Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('FlipboardLink','Flipboard Link'),'');
        $fields->addFieldToTab("Root.Social", TextField::create('LinkedinLink','Linkedin Link'),''); 
        // Return fields
        return $fields;
    }
    
}