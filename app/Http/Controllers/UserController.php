<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\MailUser;
use App\Mail\MailUpdateUser;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function utenti()
    {
        $url = url('/'); 
        $ruoli = Role::all();
        $users = User::with('roles')->get(); 


        return view('user.utenti', compact('ruoli', 'users', 'url'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //------------------------------------------VALIDAZIONE---------------------------------------------------//    
                                                                                                             //*

                $validated = $request->validate([       
                                                                                                                 
                'name' => 'required',                                                                     
                'ubicazione' => 'required', 
                'username' => 'required|string|alpha_dash|unique:users,username|min:3|max:20',                                                                         
                // 'email' => 'required|email|unique:users,email',                                                                          
                'password' => 'required', 
               
             
                ]);
                                                                                                        
                                                                                                           
                                                                                                    
    //------------------------------------------FINE VALIDAZIONE------------------------------------------------//
                                                                                                    
                                                                                                    

        
      
      $ubicazione = $request->input('ubicazione');
      $username = $request->input('username');
      $password = $request->input('password');
      $ruolo = $request->input('ruolo');


    // Creo utenza
    $user =  User::create([

       'name'=> $nome,
       'ubicazione'=> $ubicazione,
       'username'=> $username,
       'password' =>  Hash::make($password),

                         ]);

      // Assegno ruolo
      $user->assignRole($ruolo);



     //Invio mail di notifica ////
    //   $mailData = [

    //         "name" => $user->name,
    //         "ubicazione" => $ubicazione,
    //         "email" => $email,
    //         "password" => $password,
    //         "ruolo" => $ruolo
             
    //              ];

    // Mail::to($user->email)->send(new MailUser($mailData));

    


    return back()->with('status', 'utente creato correttamente, una notifica mail è stata inviata');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validated = $request->validate([       
                                                                                                                 
            'username' => 'required',                                                                     
            'ubicazione' => 'required',                                                                                                                                               
            'password' => 'required', 
            'ruolo' => 'required'
        
         
            ]);
        

      $username = $request->input('username');
      $ubicazione = $request->input('ubicazione');
      $password = $request->input('password');
      $ruolo = $request->input('ruolo');
      
        $user = User::with('roles')->find($id); 

        if($user->hasRole(['Admin', 'Operatore'])){

        $user->removeRole($user['roles'][0]['name']);

        }


        $user->username = $username;
        $user->ubicazione = $ubicazione;
        $user->password = Hash::make($password);
       
        $user->save();

        $user->assignRole($ruolo);



    //     $mailData = [

    //         "name" => $user->name,
    //         "ubicazione" => $ubicazione,
    //         "email" => $email,
    //         "password" => $password,
    //         "ruolo" => $ruolo
             
    //              ];

    // Mail::to($user->email)->send(new MailUpdateUser($mailData));




        return back()->with('status', 'dati utente aggiornati con successo, una notifica mail è stata inviata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        

        $user = User::with('roles')->find($id);

        $user->delete();


        return back()->with('status', 'utente:'.' '.$user->name.' rimosso');
    }
}
