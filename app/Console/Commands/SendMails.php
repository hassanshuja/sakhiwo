<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use PDF;


class SendMails extends Command 
{
   

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmails:contractor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Emails to Contractor according to Status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $a=array(1,2,3,4,5,6);
        array_walk($a, array('SELF' , "mystatus"));
    }
 
    public function mystatus($value,$key)
        {
            $singleContractor = array();
            $totalQuotes = \DB::table('quotes')->where('status', '=' , $value)
                            ->leftJoin('status', 'status.id' , '=', 'quotes.status')
                            ->select('quotes.*', 'status.type')
                            ->orderBy('contractor_id')->get();

            $uniqueContractor = \DB::table('quotes')->where('status', '=' , $value)->groupBy('contractor_id', 'status')->pluck('contractor_id');

            if($value == '6'){
                $district_division = \DB::table('quotes')->where('status', '=' , $value)->groupBy('contractor_id','district_id')->orderBy('district_id')->select('district_id','contractor_id')->get();
                //SELECT * FROM `quotes` where status =6  group by contractor_id,district_id order by district_id

                $vetting_query = \DB::table('quotes')->where('status', '=' , $value)
                            ->leftJoin('status', 'status.id' , '=', 'quotes.status')
                            ->select('quotes.*', 'status.type')
                            ->groupBy('contractor_id','status','district_id','job_card_number')
                            ->orderBy('contractor_email','district_id')->get();
                //This is mysql query same as above laravel query
                //SELECT * FROM `quotes` where status=6 GROUP BY contractor_id,status,district_id,job_card_number order by contractor_email,district_id

                foreach($district_division as $districts){

                        foreach($vetting_query as $search){
                            if($districts->contractor_id == $search->contractor_id && $districts->district_id == $search->district_id && $search->status == '6'){
								$singleContractor[] = $search;
                            }
                        }

                     if(count($singleContractor) > 0){

                      	$pdf = PDF::loadView('admin.emails.mailpdf', compact('singleContractor'))->setPaper('a4', 'landscape');
                        //unlink(asset('assets/upload/myfile.pdf'))
                        $dataemail = array('name' => 'your name', 'status', $singleContractor, 'singleContractor' => $singleContractor);

                       try{

                        Mail::send('admin.emails.cronEmail', $dataemail, function ($message) use ($pdf, $singleContractor) {
                            $message->from('kena@sakhiwo.com', 'Vetted Claims');
                            $message->to($singleContractor[0]->contractor_email)->subject('Vetted Claims')->replyTo('kena@sakhiwo.com')->cc('finance.sakhiwo@gmail.com');
                            $message->attachData($pdf->output(), 'vetting.pdf');
                            });
                        echo 'sent';
                        echo '<br>';
                         unset($singleContractor);
                         $singleContractor = array();
                    }catch(Exception $e){
                        echo 'error sending email '. $e->getMessage();
                        echo '<br>';
                    }

                         
                    }
                       
                }
                
            }else{


                foreach($uniqueContractor as $contract){
                    foreach($totalQuotes as $search){
                      if($contract == $search->contractor_id){
                        
                        $singleContractor[] = $search;
                        
                      }
                    
                    }
                    if(count($singleContractor) > 0){
                        $pdf = PDF::loadView('admin.emails.mailpdf', compact('singleContractor'))->setPaper('a4', 'landscape');
                        //unlink(asset('assets/upload/myfile.pdf'))

                        $dataemail = array('name' => 'your name', 'status', $singleContractor, 'singleContractor' => $singleContractor);

                        try{
                            Mail::send('admin.emails.cronEmail', $dataemail, function ($message) use ($pdf, $singleContractor) {
                            $message->from('kena@sakhiwo.com', $singleContractor[0]->type);
                            $message->to($singleContractor[0]->contractor_email)->subject($singleContractor[0]->type)->replyTo('kena@sakhiwo.com')->cc('finance.sakhiwo@gmail.com');

                            $message->attachData($pdf->output(), $singleContractor[0]->type.'.pdf');
                            });
                            echo 'sent';
                            echo '<br>';
                        }catch(Exception $e){
                            echo 'error sending email '. $e->getMessage();
                            echo '<br>';
                        }
                    }
                     unset($singleContractor);
                     $singleContractor = array();
                }
            }
        }
}