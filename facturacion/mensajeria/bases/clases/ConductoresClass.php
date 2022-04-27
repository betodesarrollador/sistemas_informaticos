<?php

require_once("../../../framework/clases/ControlerClass.php");

final class Conductores extends Controler{

  public function __construct(){
     parent::__construct(3);    
  }

  protected function setCampos(){
  
	//campos formulario
	$this -> Campos[tercero_id] = array(
		name	=>'tercero_id',
		id		=>'tercero_id',
		type	=>'hidden',
		datatype=>array(
			type	=>'autoincrement',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero','conductor'),
			type	=>array('primary_key','column'))
	);
	  
	$this -> Campos[conductor_id] = array(
		name	=>'conductor_id',
		id	=>'conductor_id',
		type	=>'hidden',
		required=>'no',
    	        datatype=>array(
			type	=>'autoincrement',
			length	=>'11'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('primary_key'))
	);
	
	$this -> Campos[tipo_persona_id] = array(
		name	=>'tipo_persona_id',
		id		=>'tipo_persona_id',
		type	=>'hidden',
		value	=>'1',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[tipo_identificacion_id] = array(
		name	=>'tipo_identificacion_id',
		id		=>'tipo_identificacion_id',
		type	=>'select',
		required=>'yes',
		options=>array(),
		selected=>'1',
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_identificacion] = array(
		name	=>'numero_identificacion',
		id		=>'numero_identificacion',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[lugar_expedicion_cedula] = array(
		name	=>'lugar_expedicion_cedula',
		id		=>'lugar_expedicion_cedula',
		type	=>'text',
		required=>'yes',
    	datatype=>array(
			type	=>'text',
			length	=>'20'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[primer_apellido] = array(
		name	=>'primer_apellido',
		id		=>'primer_apellido',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
    $this -> Campos[segundo_apellido] = array(
		name	=>'segundo_apellido',
		id		=>'segundo_apellido',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[primer_nombre] = array(
		name	=>'primer_nombre',
		id		=>'primer_nombre',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[segundo_nombre] = array(
		name	=>'segundo_nombre',
		id		=>'segundo_nombre',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[ubicacion] = array(
		name	=>'ubicacion',
		id	    =>'ubicacion',
		type	=>'text',
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ubicacion_hidden')
	);
		
	$this -> Campos[ubicacion_id] = array(
		name	=>'ubicacion_id',
		id		=>'ubicacion_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'integer',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
		
	$this -> Campos[direccion]  = array(
		name	=>'direccion',
		id		=>'direccion',
		type	=>'text',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'100'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_vivienda]  = array(
		name	=>'tipo_vivienda',
		id	=>'tipo_vivienda',
		type	=>'select',
		options	=> array(array(value=>'A',text=>'Arriendo'),array(value=>'P',text=>'Propia')),
		//required=>'yes',
		datatype=>array(
			type	=>'alpha'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[barrio]  = array(
		name	=>'barrio',
		id	=>'barrio',
		type	=>'text',
		value	=> '',
		datatype=>array(
			type	=>'text'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

    
	$this -> Campos[telefono]  = array(
		name	=>'telefono',
		id		=>'telefono',
		type	=>'text',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);
	
	$this -> Campos[movil]  = array(
		name	=>'movil',
		id		=>'movil',
		type	=>'text',
		value	=>'',
                required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('tercero'),
			type	=>array('column'))
	);

	$this -> Campos[tiempo_antiguedad_vivienda]  = array(
		name	=>'tiempo_antiguedad_vivienda',
		id	=>'tiempo_antiguedad_vivienda',
		type	=>'text',
		value	=>'',
        size    =>'3',
		//required=>'yes',		
		datatype=>array(
			type	=>'integer'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
		
	$this -> Campos[fecha_nacimiento_cond]  = array(
		name	=>'fecha_nacimiento_cond',
		id		=>'fecha_nacimiento_cond',
		type	=>'text',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'date',
			length	=>'10'),
                onselect=>'calculateAge',
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[edad]  = array(
		name	=>'edad',
		id	=>'edad',
		type	=>'text',
        readonly=>'true',
        size    =>'2',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'integer'
                )
	);
	
	$this -> Campos[estatura]  = array(
		name	=>'estatura',
		id	    =>'estatura',
		type	=>'text',
        size    =>'2',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type=>'text'
        ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[tipo_sangre_id]  = array(
		name	=>'tipo_sangre_id',
		id		=>'tipo_sangre_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[senales_particulares]  = array(
		name	=>'senales_particulares',
		id	=>'senales_particulares',
		type	=>'textarea',
		datatype=>array(
			type	=>'text'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[categoria_id] = array(
		name	=>'categoria_id',
		id		=>'categoria_id',
		type	=>'select',
		required=>'yes',
		options =>array(),
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[numero_licencia_cond] = array(
		name	=>'numero_licencia_cond',
		id		=>'numero_licencia_cond',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[vencimiento_licencia_cond] = array(
		name	=>'vencimiento_licencia_cond',
		id		=>'vencimiento_licencia_cond',
		type	=>'text',
		required=>'yes',
		value	=>'',
		datatype=>array(
			type	=>'date',
			length	=>'10'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[estado_civil_id] = array(
		name	=>'estado_civil_id',
		id		=>'estado_civil_id',
		type	=>'select',
		//required=>'yes',		
		options =>array(),
		datatype=>array(
			type	=>'integer',
			length	=>'11'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[contacto_cond] = array(
		name	=>'contacto_cond',
		id		=>'contacto_cond',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[personas_a_cargo] = array(
		name	=>'personas_a_cargo',
		id	=>'personas_a_cargo',
		type	=>'text',
		value	=>'',
        size    => 3,
		//required=>'yes',
		datatype=>array(
			type	=>'integer'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[numero_hijos] = array(
		name	=>'numero_hijos',
		id	    =>'numero_hijos',
		type	=>'text',
		value	=>'',
        size    => 3,
		//required=>'yes',
		value   =>'0',
		datatype=>array(
			type	=>'integer'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[arrendatario] = array(
		name	=>'arrendatario',
		id	=>'arrendatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_arrendatario] = array(
		name	=>'telefono_arrendatario',
		id	=>'telefono_arrendatario',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text'
                ),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[tel_contacto_cond] = array(
		name	=>'tel_contacto_cond',
		id		=>'tel_contacto_cond',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[libreta_mil_cond] = array(
		name	=>'libreta_mil_cond',
		id		=>'libreta_mil_cond',
		type	=>'text',
		value	=>'',
		//required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[distrito_mil_cond] = array(
		name	=>'distrito_mil_cond',
		id		=>'distrito_mil_cond',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'20'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[eps_cond] = array(
		name	=>'eps_cond',
		id		=>'eps_cond',
		type	=>'text',
		value	=>'',
		//required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	$this -> Campos[arp_cond] = array(
		name	=>'arp_cond',
		id		=>'arp_cond',
		type	=>'text',
		value	=>'',
		//required=>'yes',
		datatype=>array(
			type	=>'alpha_upper',
			length	=>'40'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
// 	$this -> Campos[antecedente_judicial_cond] = array(
// 		name	=>'antecedente_judicial_cond',
// 		id		=>'antecedente_judicial_cond',
// 		type	=>'text',
// 		value	=>'',
// 		datatype=>array(
// 			type	=>'alpha_upper',
// 			length	=>'20'),
// 		transaction=>array(
// 			table	=>array('conductor'),
// 			type	=>array('column'))
// 	);
// 	
	
 	$this -> Campos[foto] = array(
		name	=>'foto',
		id	=>'foto',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_foto'),
		settings => array(
		  width  => '400',
		  height => '420'
		)
	);
	  	 
	
 	$this -> Campos[cedulaescan] = array(
		name	=>'cedulaescan',
		id		=>'cedulaescan',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_cedula')
	);
	
 	$this -> Campos[licenciaescan] = array(
		name	=>'licenciaescan',
		id		=>'licenciaescan',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',			
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_licencia')
	);
	
 	$this -> Campos[pasadoescan] = array(
		name	=>'pasadoescan',
		id	=>'pasadoescan',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_pasado')
	);
	
 	$this -> Campos[epsescan] = array(
		name	=>'epsescan',
		id		=>'epsescan',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',		
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_eps')
	);
	
 	$this -> Campos[arpescan] = array(
		name	=>'arpescan',
		id		=>'arpescan',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_arp')
	);	  





 	$this -> Campos[huellaindiceizq] = array(
		name	=>'huellaindiceizq',
		id		=>'huellaindiceizq',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',			
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_huellaindiceizq')
	);	  


 	$this -> Campos[huellapulgarizq] = array(
		name	=>'huellapulgarizq',
		id		=>'huellapulgarizq',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',			
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_huellapulgarizq')
	);	  


 	$this -> Campos[huellapulgarder] = array(
		name	=>'huellapulgarder',
		id		=>'huellapulgarder',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',			
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_huellapulgarder')
	);	  


 	$this -> Campos[huellaindiceder] = array(
		name	=>'huellaindiceder',
		id		=>'huellaindiceder',
		type	=>'file',
		value	=>'',
		path	=>'/velotax/imagenes/transporte/conductores/',
		size	=>'70',
//		required=>'yes',			
		datatype=>array(
			type	=>'file'),
	 	transaction=>array(
			table	=>array('conductor'),
			type	=>array('column')),
		namefile=>array(
			field	=>'yes',
			namefield=>'numero_identificacion',
			text	=>'_huellaindiceder')
	);	  

	$this -> Campos[carga_por_primera_vez] = array(
		name	 =>'carga_por_primera_vez',
		id	     =>'carga_por_primera_vez',
		type	 =>'select',
		options  =>array(array(value => '0', text => 'NO'),array(value => '1', text => 'SI')),
		selected =>'0',		
		required =>'yes',
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[empresa_cargo1] = array(
		name	 =>'empresa_cargo1',
		id	     =>'empresa_cargo1',
		type	 =>'text',
		value	 =>'',
		required =>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_empresa_cargo1] = array(
		name	=>'telefono_empresa_cargo1',
		id	=>'telefono_empresa_cargo1',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer',
			length	=>'1000'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[ciudad_empresa_cargo1_txt] = array(
		name	=>'ciudad_empresa_cargo1_txt',
		id	=>'ciudad_empresa_cargo1_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_empresa_cargo1_txt_hidden')
	);

	$this -> Campos[ciudad_empresa_cargo1] = array(
		name	=>'ciudad_empresa_cargo1',
		id	    =>'ciudad_empresa_cargo1_txt_hidden',
		type	=>'hidden',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio1] = array(
		name	=>'nombre_persona_atendio1',
		id	=>'nombre_persona_atendio1',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio1] = array(
		name	=>'nombre_persona_atendio1',
		id	=>'nombre_persona_atendio1',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[cargo_persona_atendio1] = array(
		name	=>'cargo_persona_atendio1',
		id	=>'cargo_persona_atendio1',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 
	$this -> Campos[tiempo_lleva_cargando1] = array(
		name	=>'tiempo_lleva_cargando1',
		id	    =>'tiempo_lleva_cargando1',
		type	=>'text',
        size    => '3',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[rutas1] = array(
		name 	 =>'rutas1',
		id	     =>'rutas1',
		type	 =>'text',
		value	 =>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 
 
	$this -> Campos[tipo_mercancia1] = array(
		name	 =>'tipo_mercancia1',
		id	     =>'tipo_mercancia1',
		type	 =>'text',
		value	 =>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'100'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[viajes_realizados1] = array(
		name	=>'viajes_realizados1',
		id	    =>'viajes_realizados1',
		type	=>'text',
        size    => '3',
		value	 =>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 




	$this -> Campos[empresa_cargo2] = array(
		name	=>'empresa_cargo2',
		id	=>'empresa_cargo2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_empresa_cargo2] = array(
		name	=>'telefono_empresa_cargo2',
		id	=>'telefono_empresa_cargo2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer',
			length	=>'2000'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[ciudad_empresa_cargo2_txt] = array(
		name	=>'ciudad_empresa_cargo2_txt',
		id	=>'ciudad_empresa_cargo2_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_empresa_cargo2_txt_hidden')
	);

	$this -> Campos[ciudad_empresa_cargo2] = array(
		name	=>'ciudad_empresa_cargo2',
		id	    =>'ciudad_empresa_cargo2_txt_hidden',
		type	=>'hidden',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		datatype=>array(
				
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[cargo_persona_atendio2] = array(
		name	=>'cargo_persona_atendio2',
		id	=>'cargo_persona_atendio2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 
	$this -> Campos[tiempo_lleva_cargando2] = array(
		name	=>'tiempo_lleva_cargando2',
		id	=>'tiempo_lleva_cargando2',
		type	=>'text',
                size    => '3',
		value	=>'',
		required =>'yes',				
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[rutas2] = array(
		name	=>'rutas2',
		id	=>'rutas2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 
 
	$this -> Campos[tipo_mercancia2] = array(
		name	=>'tipo_mercancia2',
		id	=>'tipo_mercancia2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[viajes_realizados2] = array(
		name	=>'viajes_realizados2',
		id	=>'viajes_realizados2',
		type	=>'text',
                size    => '3',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[empresa_cargo2] = array(
		name	=>'empresa_cargo2',
		id	=>'empresa_cargo2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_empresa_cargo2] = array(
		name	=>'telefono_empresa_cargo2',
		id	=>'telefono_empresa_cargo2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer',
			length	=>'2000'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[cargo_persona_atendio2] = array(
		name	=>'cargo_persona_atendio2',
		id	=>'cargo_persona_atendio2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 
	$this -> Campos[tiempo_lleva_cargando2] = array(
		name	=>'tiempo_lleva_cargando2',
		id	=>'tiempo_lleva_cargando2',
		type	=>'text',
                size    => '3',
		value	=>'',
		required =>'yes',				
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[rutas2] = array(
		name	=>'rutas2',
		id	=>'rutas2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 
 
	$this -> Campos[tipo_mercancia2] = array(
		name	=>'tipo_mercancia2',
		id	=>'tipo_mercancia2',
		type	=>'text',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[viajes_realizados2] = array(
		name	=>'viajes_realizados2',
		id	=>'viajes_realizados2',
		type	=>'text',
        size    => '3',
		value	=>'',
		required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[empresa_cargo2] = array(
		name	=>'empresa_cargo2',
		id	=>'empresa_cargo2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_empresa_cargo2] = array(
		name	=>'telefono_empresa_cargo2',
		id	=>'telefono_empresa_cargo2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'integer',
			length	=>'2000'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[ciudad_empresa_cargo2_txt] = array(
		name	=>'ciudad_empresa_cargo2_txt',
		id	=>'ciudad_empresa_cargo2_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_empresa_cargo2_txt_hidden')
	);

	$this -> Campos[ciudad_empresa_cargo2] = array(
		name	=>'ciudad_empresa_cargo2',
		id	    =>'ciudad_empresa_cargo2_txt_hidden',
		type	=>'hidden',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio2] = array(
		name	=>'nombre_persona_atendio2',
		id	=>'nombre_persona_atendio2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[cargo_persona_atendio2] = array(
		name	=>'cargo_persona_atendio2',
		id	=>'cargo_persona_atendio2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 
	$this -> Campos[tiempo_lleva_cargando2] = array(
		name	=>'tiempo_lleva_cargando2',
		id	=>'tiempo_lleva_cargando2',
		type	=>'text',
                size    => '3',
		value	=>'',
		//required =>'yes',				
		datatype=>array(type=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[rutas2] = array(
		name	=>'rutas2',
		id	=>'rutas2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 
 
	$this -> Campos[tipo_mercancia2] = array(
		name	=>'tipo_mercancia2',
		id	=>'tipo_mercancia2',
		type	=>'text',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'text',
			length	=>'200'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[viajes_realizados2] = array(
		name	=>'viajes_realizados2',
		id	=>'viajes_realizados2',
		type	=>'text',
        size    => '3',
		value	=>'',
		//required =>'yes',				
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[empresa_cargo3] = array(
		name	=>'empresa_cargo3',
		id	=>'empresa_cargo3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_empresa_cargo3] = array(
		name	=>'telefono_empresa_cargo3',
		id	=>'telefono_empresa_cargo3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'integer',
			length	=>'3000'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[ciudad_empresa_cargo3_txt] = array(
		name	=>'ciudad_empresa_cargo3_txt',
		id	=>'ciudad_empresa_cargo3_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_empresa_cargo3_txt_hidden')
	);

	$this -> Campos[ciudad_empresa_cargo3] = array(
		name	=>'ciudad_empresa_cargo3',
		id	=>'ciudad_empresa_cargo3_txt_hidden',
		type	=>'hidden',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio3] = array(
		name	=>'nombre_persona_atendio3',
		id	=>'nombre_persona_atendio3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[nombre_persona_atendio3] = array(
		name	=>'nombre_persona_atendio3',
		id	=>'nombre_persona_atendio3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'500'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[cargo_persona_atendio3] = array(
		name	=>'cargo_persona_atendio3',
		id	=>'cargo_persona_atendio3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 
	$this -> Campos[tiempo_lleva_cargando3] = array(
		name	=>'tiempo_lleva_cargando3',
		id	=>'tiempo_lleva_cargando3',
		type	=>'text',
                size    => '3',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[rutas3] = array(
		name	=>'rutas3',
		id	=>'rutas3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 
 
	$this -> Campos[tipo_mercancia3] = array(
		name	=>'tipo_mercancia3',
		id	=>'tipo_mercancia3',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[viajes_realizados3] = array(
		name	=>'viajes_realizados3',
		id	=>'viajes_realizados3',
		type	=>'text',
                size    => '3',
		value	=>'',
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[referencia1] = array(
		name	=>'referencia1',
		id	=>'referencia1',
		type	=>'text',
		value	=>'',
		required=>'yes',
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[ciudad_referencia1_txt] = array(
		name	=>'ciudad_referencia1_txt',
		id	=>'ciudad_referencia1_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_referencia1_txt_hidden')
	);

	$this -> Campos[ciudad_referencia1_id] = array(
		name	=>'ciudad_referencia1_id',
		id	    =>'ciudad_referencia1_txt_hidden',
		type	=>'hidden',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_referencia1] = array(
		name	=>'telefono_referencia1',
		id	=>'telefono_referencia1',
		type	=>'text',
		value	=>'',
		required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);


	$this -> Campos[referencia2] = array(
		name	=>'referencia2',
		id	=>'referencia2',
		type	=>'text',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[ciudad_referencia2_txt] = array(
		name	=>'ciudad_referencia2_txt',
		id	=>'ciudad_referencia2_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_referencia2_txt_hidden')
	);

	$this -> Campos[ciudad_referencia2_id] = array(
		name	=>'ciudad_referencia2_id',
		id	    =>'ciudad_referencia2_txt_hidden',
		type	=>'hidden',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_referencia2] = array(
		name	=>'telefono_referencia2',
		id	=>'telefono_referencia2',
		type	=>'text',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[referencia3] = array(
		name	=>'referencia3',
		id	=>'referencia3',
		type	=>'text',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'text',
			length	=>'300'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	); 

	$this -> Campos[ciudad_referencia3_txt] = array(
		name	=>'ciudad_referencia3_txt',
		id	=>'ciudad_referencia3_txt',
		type	=>'text',
		value	=>'',
		datatype=>array(
			type	=>'alphanum_space'),
		suggest=>array(
			name	=>'ciudad',
			setId	=>'ciudad_referencia3_txt_hidden')
	);

	$this -> Campos[ciudad_referencia3_id] = array(
		name	=>'ciudad_referencia3_id',
		id	    =>'ciudad_referencia3_txt_hidden',
		type	=>'hidden',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);

	$this -> Campos[telefono_referencia3] = array(
		name	=>'telefono_referencia3',
		id	=>'telefono_referencia3',
		type	=>'text',
		value	=>'',
		//required=>'yes',		
		datatype=>array(
			type	=>'integer'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
 	
	$this -> Campos[estado] = array(
		name	 =>'estado',
		id		 =>'estado',
		type	 =>'select',
		required =>'yes',
		options	 =>array(array(value => 'B',text => 'BLOQUEADO'),array(value => 'D', text => 'DISPONIBLE')),
        selected => 'B',		
		datatype =>array(type=>'text'),
		transaction=>array(
			table	=>array('conductor'),
			type	=>array('column'))
	);
	
	//BOTONES
	$this -> Campos[guardar] = array(
		name	=>'guardar',
		id		=>'guardar',
		type	=>'button',
		value	=>'Guardar',
		property=>array(
			name	=>'save_ajax',
			onsuccess=>'ConductoresOnSaveUpdate')
	);
 	
	$this -> Campos[actualizar] = array(
		name	=>'actualizar',
		id		=>'actualizar',
		type	=>'button',
		value	=>'Actualizar',
		disabled=>'disabled',
		property=>array(
			name	=>'update_ajax',
			onsuccess=>'ConductoresOnSaveUpdate')
	);
	
  	$this -> Campos[borrar] = array(
		name	=>'borrar',
		id		=>'borrar',
		type	=>'button',
		value	=>'Borrar',
		disabled=>'disabled',
    	property=>array(
			name	=>'delete_ajax',
			onsuccess=>'ConductoresOnDelete')
	);
	
   	$this -> Campos[limpiar] = array(
		name	=>'limpiar',
		id		=>'limpiar',
		type	=>'reset',
		value	=>'Limpiar',
		onclick=>'ConductoresOnClear()',
	);
	
   	$this -> Campos[imprimir] = array(
		name	   =>'imprimir',
		id	   =>'imprimir',
		type	   =>'print',
		value	   =>'Imprimir',
	        displayoptions => array(
                  beforeprint => 'beforePrint',
                  form        => 0,
		  title       => 'Impresion Vehiculo',
		  width       => '700',
		  height      => '600'
		)

	);	
	
	//busqueda
   	$this -> Campos[busqueda] = array(
		name	=>'busqueda',
		id		=>'busqueda',
		type	=>'text',
		value	=>'',
		size	=>'85',
		suggest=>array(
			name	=>'buqueda_conductor',
			setId	=>'tercero_id',
			onclick	=>'setDataFormWithResponse')
	);
	
	
	$this -> SetVarsValidate($this -> Campos);
  }

  public function Main(){
  
    $this -> noCache();
    
    require_once("ConductoresLayoutClass.php");
    require_once("ConductoresModelClass.php");
	
    $Layout   = new ConductoresLayout($this -> getTitleTab(),$this -> getTitleForm());
    $Model    = new ConductoresModel();
    
    $Model  -> SetUsuarioId($this -> getUsuarioId(),$this -> getOficinaId());
	
    $Layout -> setGuardar	  ($Model -> getPermiso($this -> getActividadId(),'INSERT',$this -> getConex()));
    $Layout -> setActualizar  ($Model -> getPermiso($this -> getActividadId(),'UPDATE',$this -> getConex()));
    $Layout -> setBorrar	  ($Model -> getPermiso($this -> getActividadId(),'DELETE',$this -> getConex()));
    $Layout -> setLimpiar	  ($Model -> getPermiso($this -> getActividadId(),'CLEAR',$this -> getConex()));
    $Layout -> setImprimir	  ($Model -> getPermiso($this -> getActividadId(),'PRINT',$this -> getConex()));	
    $Layout -> setCambioEstado($Model -> getPermiso($this -> getActividadId(),'STATUS',$this -> getConex()));		

	
    $Layout -> setCampos($this -> Campos);
	
	//LISTA MENU
    $Layout -> SetTiposId	    ($Model -> GetTipoId		($this -> getConex()));
    $Layout -> SetGrupoSangre	($Model -> GetGrupoSangre	($this -> getConex()));
    $Layout -> SetCategoriaLic	($Model -> GetCategoriaLic	($this -> getConex()));
    $Layout -> SetEstadoCivil	($Model -> GetEstadoCivil	($this -> getConex()));
    $Layout -> setEstado        ();	    
	
	//// GRID ////
    $Attributes = array(
      id		=>'conductores',
      title		=>'Listado de Conductores',
      sortname	=>'numero_identificacion',
      width		=>'auto',
      height	=>'250'
    );

    $Cols = array(
      array(name=>'tipo_identificacion',		index=>'tipo_identificacion',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'numero_identificacion',		index=>'numero_identificacion',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'primer_apellido',			index=>'primer_apellido',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'segundo_apellido',			index=>'segundo_apellido',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'primer_nombre',				index=>'primer_nombre',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'segundo_nombre',				index=>'segundo_nombre',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'categoria',					index=>'categoria',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tipo_sangre',				index=>'tipo_sangre',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'estado_civil',				index=>'estado_civil',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'nivel_educativo',			index=>'nivel_educativo',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'ubicacion',					index=>'ubicacion',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'direccion',					index=>'direccion',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'telefono',					index=>'telefono',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'movil',						index=>'movil',						sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'fecha_ingreso_cond',			index=>'fecha_ingreso_cond',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'numero_licencia_cond',		index=>'numero_licencia_cond',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'vencimiento_licencia_cond',	index=>'vencimiento_licencia_cond',	sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'fecha_nacimiento_cond',		index=>'fecha_nacimiento_cond',		sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'libreta_mil_cond',			index=>'libreta_mil_cond',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'distrito_mil_cond',			index=>'distrito_mil_cond',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'eps_cond',					index=>'eps_cond',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'arp_cond',					index=>'arp_cond',					sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'antecedente_judicial_cond',	index=>'antecedente_judicial_cond',	sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'contacto_cond',				index=>'contacto_cond',				sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'tel_contacto_cond',			index=>'tel_contacto_cond',			sorttype=>'text',	width=>'100',	align=>'center'),
      array(name=>'estado',						index=>'estado',					sorttype=>'text',	width=>'100',	align=>'center')
    );
    $Titles = array('TIPO IDN',
				    'IDENTIFICACION',
				    'PRIMER APELLIDO',
				    'SEGUNDO APELLIDO',
				    'PRIMER NOMBRE',
				    'SEGUNDO NOMBRE',
				    'CATEGORIA',
				    'TIPO SANGRE',
				    'ESTADO CIVIL',
				    'NIVEL EDUCATIVO',
				    'UBICACION',
				    'DIRECCION',
				    'TELEFONO',
				    'MOVIL',
				    'FECHA INGRESO',
				    'NUMERO LICENCIA',
				    'VENCE LICENCIA',
				    'FECHA NACIMIENTO',
				    'LIBRETA MIL',
				    'DISTRITO MIL',
				    'EPS COND',
				    'ARP COND',
				    'ANTECEDENTE JUDICIAL',
				    'CONTACTO COND',
				    'TEL CONT',
				    'ESTADO'
    );
    $Layout -> SetGridConductores($Attributes,$Titles,$Cols,$Model -> getQueryConductoresGrid());
    
    
    $Layout -> RenderMain();
	
    
  }

  protected function calculateAge(){

    require_once("ConductoresModelClass.php");

    $Model = new ConductoresModel();

    $fecha_nacimiento_cond = $_REQUEST['fecha_nacimiento_cond'];
	
    $edad = $Model -> getEdadConductor($fecha_nacimiento_cond,$this -> getConex());

    print $edad;

  }

  protected function onclickValidateRow(){
	  
    require_once("../../../framework/clases/ValidateRowClass.php");
	
    $row  = new ValidateRow($this -> getConex(),"tercero",$this ->Campos);
	
    print $Data = $row  -> GetData();

  }

  protected function onclickSave(){
  
  
	$vencimiento_licencia_cond = $this -> requestData('vencimiento_licencia_cond');
	
	if($vencimiento_licencia_cond < date("Y-m-d")){
	    
	  exit("La fecha de vencimiento de la licencia no puede ser menor a la fecha actual");
	
	}else{

	    require_once("ConductoresModelClass.php");
	    $Model = new ConductoresModel();	
	
		$Model -> Save($this -> Campos,$this -> getConex());
		
		if($Model -> GetNumError() > 0){
		  exit('Ocurrio una inconsistencia');
		}else{
		  exit('true');
		}	
	
	  }
	

  }

  protected function onclickUpdate(){
  
	$vencimiento_licencia_cond = $this -> requestData('vencimiento_licencia_cond');
	
	if($vencimiento_licencia_cond < date("Y-m-d")){
	
	  exit("La fecha de vencimiento de la licencia no puede ser menor a la fecha actual");
	
	}else{  
  
		require_once("ConductoresModelClass.php");
		
		$Model = new ConductoresModel();
		
		$Model -> Update($this -> Campos,$this -> getConex());
		
		if($Model -> GetNumError() > 0){
		  exit('Ocurrio una inconsistencia');
		}else{
		  exit('true');
		}
	
	}

  }
  
  protected function sendConductorMintransporte(){
    
	include_once("../../webservice/WebServiceMinTranporteClass.php");
	  
	$webService = new WebServiceMinTransporte($this -> getConex());	  
	  
	$data = array(	  
	    conductor_id              => $this -> requestData('conductor_id'),
	    numero_identificacion     => $this -> requestData('numero_identificacion'),
		nombre                    => $this -> requestData('primer_nombre').' '.$this -> requestData('segundo_nombre'),
		primer_apellido           => $this -> requestData('primer_apellido'),
		segundo_apellido          => $this -> requestData('segundo_apellido'),
		telefono                  => $this -> requestData('telefono'),
	    direccion                 => $this -> requestData('direccion'),
		categoria_id              => $this -> requestData('categoria_id'),
        numero_licencia_cond      => $this -> requestData('numero_licencia_cond'),
		vencimiento_licencia_cond => $this -> requestData('vencimiento_licencia_cond'),				
		ubicacion_id              => $this -> requestData('ubicacion_id')
	  );
	  
    $webService -> sendConductorMintransporte($data);	  
    
  
  }  
	  
  protected function onclickDelete(){
   
    require_once("ConductoresModelClass.php");
    
    $Model = new ConductoresModel();
    
    $Model -> Delete($this -> Campos,$this -> getConex());
    
    if($Model -> GetNumError() > 0){
    
      if($this -> Error == 'LLAVE_FORANEA_RESTRICT'){
        exit('NO SE PUEDE QUITAR EL REGISTRO, TIENE RELACION CON OTROS REGISTROS');
      }else{
         exit('ERROR :'.$this -> Error);
       }
       
    }else{
	exit('Se elimino correctamente el conductor');
      }

  }


//BUSQUEDA
  protected function onclickFind(){
  
    require_once("ConductoresModelClass.php");
    
    $Model     = new ConductoresModel();
    $TerceroId = trim($_REQUEST['tercero_id']);    
    $NumeroId  = trim($_REQUEST['numero_identificacion']);    
    
    if(strlen($TerceroId) > 0){
       $Data =  $Model -> selectConductoresporId($TerceroId,$this -> getConex());
    }elseif(strlen($NumeroId) > 0){
          $Data =  $Model -> selectConductoresporNumId($NumeroId,$this -> getConex());
     }else{
        exit('ERROR : LINEA '.__LINE__." ARCHIVO ".__FILE__);
       }


  $this -> getArrayJSON($Data);
  }
  
  protected function onclickPrint(){
  
    require_once("Imp_HV_ConductorClass.php");
	
    $print = new Imp_HV_Conductor($this -> getConex());
	
	$print -> printOut();
  
  }  
	
	
}

$conductores = new Conductores();

?>