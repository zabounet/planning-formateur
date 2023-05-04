<?php

namespace App\Core;

use Exception;

class CustomException extends Exception
{
    public function __construct(string $message='',int $code=0,$previous=null)
    {
        parent::__construct($message, $code, $previous);
    }

    static function PhpFatalErrors()
	{
		$lastError = error_get_last();
		if(!is_null($lastError))
        static::PhpErrors($lastError['type'],$lastError['message'],$lastError['file'],$lastError['line']);
    }
    
	/* It's a function that will be called when a PHP error occurs. */
	static function PhpErrors($errno,$errstr,$errfile,$errline)
	{
        $Action = [];
        $Action['msg'] 		='';
		$Action['exit'] 	=true;
		$Action['display']	=false;
		$Action['notify']	=false;
		
		switch ($errno)
		{
			case E_USER_NOTICE :
			case E_NOTICE :
			{
			    $Action['exit'] 	= false;
			    $Action['display'] 	= false;
			    $Action['notify'] 	= true;
			    $Action['type'] 	= "Notification (".$errno.")";
				break;
			}
			case E_COMPILE_WARNING :
			case E_CORE_WARNING :
			case E_USER_WARNING :
			case E_WARNING :
			case E_DEPRECATED :
			case E_USER_DEPRECATED :
			{
			    $Action['exit'] 	= false;
			    $Action['display'] 	= false;
			    $Action['notify'] 	= false;
			    $Action['type'] 	= "Avertissement (".$errno;
			    break;
			}
			case E_PARSE :
			{
			   	$Action['exit'] 	= true;
			    $Action['display'] 	= false;
			    $Action['notify'] 	= true;
			    $Action['type'] 	= "<h1 style='padding: 0; margin: 0 ;font-size: 3rem; color: red; margin-top: 45vh; text-align: center;'>Oups ! Il semblerait que les développeurs aient fait une bourde. Veuillez contacter l'administrateur du site afin de résoudre le problème.</h1>";
			    break;
			}
			case E_COMPILE_ERROR :
			case E_CORE_ERROR :
			case E_USER_ERROR :
			case E_ERROR :
			{
			   	$Action['exit'] 	= true;
			    $Action['display'] 	= false;
			    $Action['notify'] 	= true;
			    $Action['type'] 	= "<h1 style='padding: 0; margin: 0 ;font-size: 3rem; color: red; margin-top: 45vh; text-align: center;'>/!\ Ce système est sur le point de s'autodétruire. /!\</h1> <h2 style='text-align:center;'> Veuillez ordonner l'évacuation immédiate des lieux dans un rayon de 1kilomètre. Autodestruction dans 30 secondes.</h2> <p style='text-align: center; font-size:1.25rem;'>Si le problème persiste, veuillez contacter l'admnistrateur.</p>";
			    break;
			}
			default :
			{
			    $Action['exit'] 	= false;
			    $Action['display'] 	= false;
			    $Action['notify'] 	= true;
			    $Action['type'] 	= "<h1> Désolé, une erreur est survenue </h1>";
			    break;
			}
	    }
	    
	    if($Action['notify'] === true)
	    {
		    echo $Action['type'];
		}
	    if($Action['exit'] === true)
	    {
		    exit();
		}
	}
}