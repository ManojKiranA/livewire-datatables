<?php

namespace App\Http\Livewire;

use App\User;
use Exception as BaseException;
use Livewire\Component;
use Spatie\SslCertificate\SslCertificate as SpatieSslCertificate;
use Spatie\SslCertificate\Exceptions\CouldNotDownloadCertificate\HostDoesNotExist;
use Illuminate\Support\Str;
use Spatie\SslCertificate\Exceptions\CouldNotDownloadCertificate\UnknownError;
use Spatie\SslCertificate\Exceptions\InvalidUrl;
use Spatie\Dns\Dns;

class SSLCertificate extends Component
{
    public $websiteHost;

    public $webSiteSSLInformation;

    public function render()
    {
        
        if($this->websiteHost):

            $r = User::query()->paginate(10,['*'],'customPageName');

            try {
                $sslGet = SpatieSslCertificate::createForHostName($this->websiteHost);

                $mixedMethodsToRun = [
                    'getIssuer' => 'Issued By',
                    'getDomain' => 'Domanin Name',
                    'getSignatureAlgorithm' => 'Signature Algorithm',
                    'getFingerprint' => 'Fingerprint',
                    'getFingerprintSha256' => 'Fingerprint Sha256',
                    'validFromDate' => 'Date of Purchase',
                    'expirationDate' => 'Date of Expiry',
                    'daysUntilExpirationDate' => 'Days Left for Expiry',
                    'getAdditionalDomains' => 'Additional Domains',
                    
                ];

                $booleanMethodsToRun = [
                    'isExpired' => 'Is Domain Expired',
                    'isValid' => 'Is Certificate Valid',                
                ];

                foreach($mixedMethodsToRun as $eachMixedMethod => $mixedMethodAlaiases):
                    $sslDataArray[$mixedMethodAlaiases] = $sslGet->$eachMixedMethod();
                endforeach;

                foreach($booleanMethodsToRun as $eachBoolMethod => $boolMethodAlaiases):
                    $sslDataArray[$boolMethodAlaiases] = $sslGet->$eachBoolMethod() ? 'YES' : 'NO';
                endforeach;

                $this->webSiteSSLInformation = $sslDataArray;          

            } catch (BaseException $baseException) {
                $this->webSiteSSLInformation = $baseException->getMessage();
            }


        endif;   
    
        return view('livewire.s-s-l-certificate');
    }
}
