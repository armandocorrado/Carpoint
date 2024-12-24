<?php

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;





function importNuoviSybase() {



$dsn = "carpoint";
$user = "dba";
$password = "pinocchio";



// if (!$conn) {
//     echo "Connessione non riuscita.";
//     exit;
// }

// echo "Connessione riuscita.";

$conn = odbc_connect($dsn, $user, $password); 


$sql ="SET ROWCOUNT 800 SELECT 
n_veicoli.id_veicolo,
n_veicoli.veicolo,
n_veicoli.telaio,
n_veicoli.targa,
n_veicoli.marca,
n_veicoli.modello,
n_veicoli.versione,
coalesce(n_veicoli.descrizione,n_versioni.descrizione) as descr_versione,
n_colori.colore as cod_colore,
n_colint.colore as cod_interni,
Coalesce(n_colorver.descrizione,n_colori.descrizione) as descr_col,
n_colori.metallizzato,
Coalesce(n_colintver.descrizione,n_colint.descrizione) as descr_int,
n_versioni.alimentazione,
n_versioni.tipo_veicolo,
n_versioni.numposti, 
n_versioni.cilindrata, 
n_versioni.tipo_trazione,
n_versioni.pneumatici,
n_versioni.massa,
n_versioni.portata,
n_versioni.potenzakw,
n_veicoli.linea,
veicoli_linee.descrizione,
veicoli_linee.categoria,
n_veicoli.provenienza,  
n_veicoli.ubicazione, 
ubicazioni.descrizione as descrizione_ubicazioni,   
n_veicoli.parcheggio,
n_veicoli.filiale,
n_veicoli.id_mandato,
n_veicoli.status,
n_veicoli.blocco_sv,
n_veicoli.ordine_sv,
n_veicoli.data_conferma,
n_veicoli.data_assegnazione,
n_veicoli.data_arrivo,
n_veicoli.data_consegna, 
n_veicoli.data_immatricolazione,
n_veicoli.data_completamento_ccf,
n_veicoli.data_uscita,
n_veicoli.data_inizio_garanzia, 
n_veicoli.id_agente_prenotazione,
age_pren.descrizione as descr_agente_prenotazione,
n_veicoli.data_prenotazione,
n_veicoli.scadenza_prenot,
conformita_agenzie.id_agenzia,
conformita_agenzie.data_consegna,
conformita_agenzie.data_restituzione,
n_testata_contratto.tipo_contratto,
n_testata_contratto.codsede,
n_testata_contratto.data_contratto,
n_testata_contratto.numero_contratto,
n_testata_contratto.id_gruppo_agenti,
n_testata_contratto.codice_fidelizzazione,
n_testata_contratto.id_cliente,
n_testata_contratto.cod_punto_vendita,
age_contr.descrizione as descr_agente_contratto,
n_veicoli.data_fattura_a,
n_veicoli.num_fattura_a,
n_veicoli.data_fattura_v,
n_veicoli.num_fattura_v,
n_veicoli.id_distinta_conform as numero_dist_conf_ritiro,
n_veicoli.data_rich_preconsegna,
n_veicoli.data_prevista_consegna,
n_veicoli.data_prev_ritiro_conf,
n_veicoli.vendibilita,
n_veicoli.num_ordine_commerciale,
n_veicoli.num_ordine_fabbrica,
Coalesce(n_testata_contratto.num_ordine_cli,n_distinta_veicoli.num_ordine_cli) as 'n_veicoli_num_ordine_cli',
n_veicoli.data_previsto_arrivo,
clienti.ragione_sociale,
vs_n_vei_giorni_giacenza.gg_giac_da_dt_arrivo as gg_giacenza,
vs_n_vei_giorni_giacenza.gg_giac_da_ultimo_mov_int as gg_giacenza_da_ultimo_tra,
vs_n_vei_giorni_giacenza.gg_giac_da_dt_fattura as gg_giacenza_da_fattacq,
n_veicoli.data_rich_trasporto,
(case when n_veicoli.num_contratto is not null then 'N' when fn_veicoli_count_campagne(n_veicoli.id_veicolo)>0 then 'S' else 'N' end) as campagne_attive,
(case when campagne_attive = 'S' then '*' else '' end) as flag_campagne,
segn.descrizione as segnalatore,   
gest_vei_aziendali.data_repertorio_ritiro,   
gest_vei_aziendali.num_repertorio_ritiro,   
gest_vei_aziendali.data_repertorio_vendita,   
gest_vei_aziendali.num_repertorio_vendita,
gest_vei_aziendali.scadenza_bollo,
cod_colore||' - '||descr_col as colore,
cod_interni||' - '||descr_int as interni,
n_testata_contratto.numero_ocf,
n_testata_contratto.data_ocf,
tipo_cliente_ocf_cm.codice as tipo_cliente_ocf,
n_testata_contratto.tipo_cliente_ccf,
n_testata_contratto.codice_cliente_gruppo,
(select sum(dettaglio_acquisto_veicoli_nuovi.imponibile)
from dettaglio_acquisto_veicoli_nuovi 
where dettaglio_acquisto_veicoli_nuovi.id_acqveinuovo=n_veicoli.id_acqveinuovo
and dettaglio_acquisto_veicoli_nuovi.tipo_costo in ('00','10')) as fattacq_vei_opt,
(select n_dettaglio_contratto.prezzo_veicolo + n_dettaglio_contratto.accessori - 
fn_round_a(fn_scorpora(n_dettaglio_contratto.sconto_lire+n_dettaglio_contratto.campagne,n_dettaglio_contratto.perciva),0.01)
from  n_dettaglio_contratto
where  n_dettaglio_contratto.id_contratto=n_veicoli.num_contratto) as contr_vei_opt_nosconto,
right(n_veicoli.versione,1) as serie_fiat,
n_status_ordine.codice as 'cod_status_ordine',
n_status_ordine.descrizione as 'descr_status_ordine',
age_contr.codice_vs as 'cod_agente',
segn.codice_vs as 'cod_segnalatore',
n_veicoli.settimana_conferma as 'sett_conferma',
n_veicoli.settimana_prev_cons as  'sett_prev_arrivo',
n_veicoli.settimana_prev_produzione as 'sett_prev_produzione',
n_veicoli.settimana_conf_produzione as 'sett_conf_produzione',
n_veicoli.anno_commissione as 'anno_commissione_vgi',
n_veicoli.numero_commissione as 'numero_commissione_vgi',
n_veicoli.data_arrivo_sede as 'data_arrivo_sede',
n_veicoli.data_ric_doc_fo as 'data_ok_preparatore',
n_veicoli.data_rich_mapo as 'data_rich_mapo',
n_veicoli.note_preparazione as 'note_preparatore',
n_veicoli.cartellino as 'cartellino',
(select list(Date(veicoli_usati.data_immatricolazione)) FROM veicoli_usati where veicoli_usati.num_contratto_ritiro_n=n_veicoli.num_contratto) as 'data_imm_ritiro',
n_veicoli.data_produzione as 'data_produzione',
n_veicoli.data_termine_modifica_prodotti as 'data_termine_modifica_prodotti',
cm_mandati.descrizione as descrizione_mandato,
(select list(veicoli_usati.targa) FROM veicoli_usati where veicoli_usati.num_contratto_ritiro_n=n_veicoli.num_contratto) as 'targhe_ritiro',
(select list(n_iniziative.cod_iniziativa)
		from
		n_vei_preiniz 
			join n_iniziative on n_iniziative.id_iniziativa=n_vei_preiniz.id_iniziativa
			and n_vei_preiniz.id_veicolo=n_veicoli.id_veicolo) as cod_iniziative_preq,
(select coalesce(sum(coalesce(n_vei_preiniz.importo_da_liquidare,0)),0)
		from
		n_vei_preiniz 
			join n_iniziative on n_iniziative.id_iniziativa=n_vei_preiniz.id_iniziativa
			and n_vei_preiniz.id_veicolo=n_veicoli.id_veicolo) as tot_iniziativa_preq,

(select list(n_iniziative.cod_iniziativa)
from 
n_vei_iniz join dummy on n_vei_iniz.id_veicolo=n_veicoli.id_veicolo
join n_liquid_iniz on n_liquid_iniz.id_veicolo=n_vei_iniz.id_veicolo and 
n_liquid_iniz.id_iniziativa=n_vei_iniz.id_iniziativa
join n_iniziative on n_liquid_iniz.id_iniziativa = n_iniziative.id_iniziativa ) as cod_iniziative_liquidate,

(select coalesce(sum(n_liquid_iniz.importo * n_liquid_iniz.segno),0)
from 
n_vei_iniz join dummy on n_vei_iniz.id_veicolo=n_veicoli.id_veicolo
join n_liquid_iniz on n_liquid_iniz.id_veicolo=n_vei_iniz.id_veicolo and 
n_liquid_iniz.id_iniziativa=n_vei_iniz.id_iniziativa) as tot_iniziative_liquidate,

(select   list(n_iniziative.cod_iniziativa)
from
  n_vei_iniz inner join n_iniziative on n_vei_iniz.id_iniziativa = n_iniziative.id_iniziativa 
			and n_veicoli.id_veicolo = n_vei_iniz.id_veicolo )as cod_iniziative_liquidabili,
(select  coalesce(sum(coalesce(n_vei_iniz.importo_liquidabile,0) ),0)
from
 n_vei_iniz inner join n_iniziative on n_vei_iniz.id_iniziativa = n_iniziative.id_iniziativa 
			and n_veicoli.id_veicolo = n_vei_iniz.id_veicolo )as tot_iniziative_liquidabili,
n_veicoli.importo_assegnato,
n_veicoli.importo_optionals_assegnato,
(select list(n_optveic.optional order by n_optveic.optional ASC) from n_optveic join  dummy on n_optveic.id_veicolo=n_veicoli.id_veicolo and  n_optveic.serie='N' ) as 'elenco_cod_opt_rich',
(select list(Coalesce(n_optveic.descrizione,n_optver.descrizione) order by n_optver.optional ASC) from n_optveic  join  dummy on n_optveic.id_veicolo=n_veicoli.id_veicolo and  n_optveic.serie='N' join
 n_optver on n_optver.marca=n_veicoli.marca and n_optver.modello=n_veicoli.modello and 
n_optver.versione=n_veicoli.versione and n_optver.optional= n_optveic.optional) as 'elenco_descr_opt_rich',
n_marche.descrizione as descrizione_marca,
n_modelli.descrizione as descrizione_modello,
n_versioni.cv_fiscali,
coalesce(n_veicoli.prezzo_aziendale,0) as prezzo_aziendale,
n_veicoli.premio_agente,
coalesce((select sum(acquisto_veicoli_nuovi.totale * acquisto_veicoli_nuovi.segno) from acquisto_veicoli_nuovi join dummy on n_veicoli.id_veicolo=acquisto_veicoli_nuovi.id_veicolo),0) as tot_costi_consuntivi,
coalesce((select sum(acquisto_veicoli_nuovi.totale * acquisto_veicoli_nuovi.segno) from acquisto_veicoli_nuovi join dummy on n_veicoli.id_veicolo=acquisto_veicoli_nuovi.id_veicolo join tipi_doc on tipi_doc.codice=acquisto_veicoli_nuovi.tipo_documento and tipi_doc.gestione='O'),0) as tot_costi_ripristino_consuntivi,
gest_vei_aziendali.cod_infocar,
 gest_vei_aziendali.km_percorsi,
(select list(n_accessori_veic.optional order by n_accessori_veic.optional ASC) from n_accessori_veic join  dummy on n_accessori_veic.id_veicolo=n_veicoli.id_veicolo ) as 'elenco_cod_accessori',
(select list(n_accessori_veic.descrizione order by n_accessori_veic.optional ASC) from n_accessori_veic  join  dummy on n_accessori_veic.id_veicolo=n_veicoli.id_veicolo) as 'elenco_descr_accessori'

FROM n_veicoli 
join n_versioni on n_veicoli.marca=n_versioni.marca and n_veicoli.modello=n_versioni.modello and n_veicoli.versione=n_versioni.versione
join n_modelli on n_veicoli.marca=n_modelli.marca and n_veicoli.modello=n_modelli.modello
left join n_marche on n_marche.marca=n_veicoli.marca
left outer join n_colori on n_veicoli.marca=n_colori.marca and n_veicoli.colore_ext=n_colori.colore 
left outer join n_colint on n_veicoli.marca=n_colint.marca  and n_veicoli.colore_int=n_colint.colore 
left outer join n_colorver on  n_veicoli.marca = n_colorver.marca  and  n_veicoli.modello = n_colorver.modello  and 
	n_veicoli.versione = n_colorver.versione  and 	 n_veicoli.colore_ext = n_colorver.colore 
left outer join n_colintver on  n_veicoli.marca = n_colintver.marca  and  n_veicoli.modello = n_colintver.modello  and 
	n_veicoli.versione = n_colintver.versione  and 	 n_veicoli.colore_int = n_colintver.colore_int
left outer join n_dettaglio_contratto on n_dettaglio_contratto.id_veicolo=n_veicoli.id_veicolo
left outer join n_testata_contratto on n_dettaglio_contratto.id_contratto=n_testata_contratto.id_contratto  	
left outer join clienti	on n_testata_contratto.id_cliente = clienti.codice_cliente
left outer join gruppo_agenti  as age_contr on age_contr.id_gruppo_agenti=n_testata_contratto.id_gruppo_agenti
left outer join gruppo_agenti  as age_pren on age_pren.id_gruppo_agenti=n_veicoli.id_agente_prenotazione
left outer join veicoli_linee on n_veicoli.linea=veicoli_linee.linea
left outer join ubicazioni on n_veicoli.ubicazione=ubicazioni.ubicazione 
left outer join distinta_conformita on distinta_conformita.id_distinta_conform=n_veicoli.id_distinta_conform
left outer join conformita_agenzie on n_veicoli.id_confagen=conformita_agenzie.id_confagen
join vs_n_vei_giorni_giacenza on vs_n_vei_giorni_giacenza.id_veicolo=n_veicoli.id_veicolo
left outer join n_distinta_veicoli on n_distinta_veicoli.id_distinta=n_veicoli.id_distinta_veicoli
left outer join gruppo_agenti as segn on segn.id_gruppo_agenti=n_testata_contratto.id_segnalatore
left outer join gest_vei_aziendali on n_veicoli.id_veicolo=gest_vei_aziendali.id_veicolo
left outer join n_status_ordine on n_status_ordine.id_status_ordine=n_veicoli.id_status_ordine
left outer join cm_mandati on  n_veicoli.id_mandato=cm_mandati.id_mandato
left join tipo_cliente_ocf_cm on tipo_cliente_ocf_cm.id=n_testata_contratto.id_tipo_cliente_ocf_cm
 WHERE n_veicoli.linea IN ('00')  
 AND ( (n_veicoli.status ='C') OR (n_veicoli.status ='T')  OR n_veicoli.status ='A')";
 // status, aggiungere "v", "U"
 // linea--> togliere tutte


//        AND n_veicoli.id_veicolo = ('302500')  

				$array = array();
				
			// $sql = "select * FROM  n_veicoli";
				
			$stmt = odbc_prepare($conn, $sql);
			$result = odbc_execute($stmt); 
			
	      
	      
			//nomi colonne /////////////////////////
			$nomeCol = array();

			for($n=1; $n<=135; $n++ ){
			$nomeCol[] = odbc_field_name($stmt , $n ); 

			} 

			//////////////////////////////////////
		  
             // numero colonne
			$numeroRow = odbc_num_fields($stmt);  //135;

			/////////////////////////////////////


				while (odbc_fetch_row($stmt)) {
					for ($i = 1; $i <= odbc_num_fields($stmt); $i++) {
						$array[] =  odbc_result($stmt, $i);
						
					}
					
				}

		    //////////////////////////////////////


						
				$array = array_chunk($array, $numeroRow); 
				
				//numero array
				$numArray = count($array);

				for($k=0; $k < $numArray; $k++){
				$array[$k] = array_combine($nomeCol,$array[$k]);

				}

            //   $array[0] =  array_combine($nomeCol,$array[0]);

	
				return $array;
				
			

				adbc_close($conn);




// if (!$stmt) {
//     // echo "Preparazione della query non riuscita.";
//     odbc_close($conn);
//     exit;
// }
// else{

// 	echo "query riuscita";
// }






    }


	function importUsatiSybase() {



		$dsn = "carpoint";
		$user = "dba";
		$password = "pinocchio";
		
		
		
		// if (!$conn) {
		//     echo "Connessione non riuscita.";
		//     exit;
		// }
		
		// echo "Connessione riuscita.";
		
		$conn = odbc_connect($dsn, $user, $password); 
		
		
$qUSATI="SET ROWCOUNT 800 SELECT  
    veicoli_usati.usato as 'id_veicolo',
    veicoli_usati.targa, 
	veicoli_usati.vin, 
	veicoli_usati.codice_veicolo, 
	u_marche.descrizione as marca, 
    u_modelli.descrizione as modello, 
    u_versioni.descrizione,
	u_colori.descrizione as colore,   
	u_colint.descrizione as colint,   
	veicoli_usati.status_veicolo,   
	veicoli_usati.vendibilita,   
	ubicazioni.ubicazione,
	ubicazioni.descrizione as desc_ubicazione,   
	veicoli_tipi_titiro.descrizione,   
	veicoli_usati.storno_reg_margine,   
	veicoli_provenienze.descrizione,   
	veicoli_destinazioni.descrizione,
	veicoli_destinazioni.tipologia,
	veicoli_usati.parcheggio,   
	canale_vendita.codice,   
	canale_vendita.descrizione,   
	veicoli_linee.descrizione,   
	cm_mandati.descrizione,
	veicoli_usati.num_repertorio_ritiro,   
	veicoli_usati.data_procura_ritiro,   
	veicoli_usati.data_fattura_a,   
	veicoli_usati.num_fattura_a,   
	tipi_veicolo.descrizione,   
	veicoli_usati.alimentazione,
	veicoli_usati.km_percorsi,
	veicoli_usati.data_immatricolazione,   
	veicoli_usati.num_proprietari,      
	veicoli_usati.cilindrata,   
	veicoli_usati.massa,   
	veicoli_usati.portata,   
	veicoli_usati.cv_fiscali,   
	veicoli_usati.numposti,   
	veicoli_usati.scadenza_bollo,   
	veicoli_usati.data_revisione,   
	veicoli_usati.data_inserimento,   
	veicoli_usati.data_previsto_ritiro,
	veicoli_usati.data_arrivo,   
	veicoli_usati.dt_decor_proprieta,   
	veicoli_usati.data_consegna,   
	veicoli_usati.valore_di_ritiro,   
	veicoli_usati.valore_infocar,   
	veicoli_usati.premio_agente,   
	veicoli_usati.prezzo_vendita,   
	(veicoli_usati.valvend_pers - veicoli_usati.variazione_agente) as val_vend_infocar,
	veicoli_usati.prezzo_vendita_effettivo,   
	veicoli_usati.prezzo_nuovo,   
	veicoli_usati.est_gar_autoexpert,   
	veicoli_usati.codice_garanzia,   
	veicoli_usati.num_contr_ext_gar,   
	veicoli_usati.data_inizio_garanzia,   
	veicoli_usati.data_fine_garanzia,   
	veicoli_usati.data_prenotazione,
	veicoli_usati.scadenza_prenotazione,   
	testata_contratto.numero_contratto,   
	testata_contratto.data_contratto,   
	veicoli_usati.num_repertorio_vendita,   
	veicoli_usati.data_procura_vendita,   
	veicoli_usati.data_fattura_v,   
	veicoli_usati.num_fattura_v, 
	veicoli_usati.id_agente_ritiro,
	veicoli_usati.canale_uscita,
	testata_contratto.id_cliente as id_cliente_contratto,
	testata_contratto.id_gruppo_agenti as id_agente_vendita,
	testata_contratto.cod_punto_vendita,
	testata_contratto.tipologia_pagamento,
	vs_u_vei_giorni_giacenza.gg_giac_da_ultimo_mov_int,
	vs_u_vei_giorni_giacenza.gg_giac_da_dt_arrivo as gg_giacenza,
	veicoli_usati.descrizione,
	veicoli_usati.valore_di_ritiro_gest as 'valore_gestionale',
	Coalesce(veicoli_usati.preventivo_spese_meccaniche,0)+Coalesce(veicoli_usati.preventivo_spese_carrozzeria,0)+
     Coalesce(veicoli_usati.spese_varie_infc,0)+Coalesce(veicoli_usati.spese_fisse_infc,0) as 'costi_ripristino',
	Coalesce(veicoli_usati.valore_infocar,0)- Coalesce(veicoli_usati.variazione_agente,0) + costi_ripristino as 'valore_ritiro_infocar_pers',
	(case when veicoli_usati.num_contratto_vendita is not null then 'N' when fn_veicoli_count_campagne_usato(veicoli_usati.usato)>0 then 'S' else 'N' end) as campagne_attive,
	(case when campagne_attive = 'S' then '*' else '' end) as flag_campagne,
	veicoli_usati.versione,
	veicoli_usati.kw,
	veicoli_usati.prezzo_vendita_alt,
	veicoli_usati.prezzo_vendita_alt_2,
	coalesce((select sum(acquisto_veicoli_usati.totale)
	from acquisto_veicoli_usati join dummy on acquisto_veicoli_usati.id_usato=veicoli_usati.usato),0) as tot_doc_acq,
	coalesce((select sum(acquisto_veicoli_usati.totale)
	from acquisto_veicoli_usati join dummy on acquisto_veicoli_usati.id_usato=veicoli_usati.usato
	join tipi_doc on tipi_doc.codice=acquisto_veicoli_usati.tipo_documento and tipi_doc.gestione='O'),0) as tot_doc_acq_ripristini,
vs_u_vei_giorni_giacenza.gg_giac_da_dt_fattura

FROM
	veicoli_usati 
	left outer join veicoli_tipi_titiro on dba.veicoli_tipi_titiro.tipo_ritiro = veicoli_usati.tipo_ritiro   
	left outer join ubicazioni on  veicoli_usati.ubicazione = ubicazioni.ubicazione    
	left outer join u_colint on  u_colint.marca = veicoli_usati.marca_interni  and u_colint.colore = veicoli_usati.colore_int 
	left outer join u_colori on  u_colori.marca = veicoli_usati.marca_colore  and  u_colori.colore = veicoli_usati.colore_ext  
	left outer join veicoli_provenienze on    veicoli_usati.provenienza = veicoli_provenienze.provenienza  
	left outer join  testata_contratto  on veicoli_usati.num_contratto_vendita = testata_contratto.id_contratto
	left outer join  dettaglio_contratto on dettaglio_contratto.id_contratto = testata_contratto.id_contratto
	left outer join  canale_vendita on  canale_vendita.codice = veicoli_usati.cod_canale_vendita  
	left outer join  tipi_veicolo on     tipi_veicolo.tipo_veicolo=veicoli_usati.tipo_veicolo
	left outer join   veicoli_linee on veicoli_linee.linea = veicoli_usati.linea 
	left outer join  cm_mandati  on cm_mandati.id_mandato = veicoli_usati.id_mandato
	left outer join u_marche on veicoli_usati.marca = u_marche.marca
	left outer join u_modelli on veicoli_usati.marca = u_modelli.marca and veicoli_usati.modello= u_modelli.modello
	left outer join u_versioni on veicoli_usati.marca = u_versioni.marca and veicoli_usati.modello= u_versioni.modello
		and veicoli_usati.versione= u_versioni.versione
	left outer join veicoli_destinazioni on veicoli_usati.destinazione = veicoli_destinazioni.destinazione
	left outer join vs_u_vei_giorni_giacenza on
		vs_u_vei_giorni_giacenza.usato = veicoli_usati.usato WHERE (veicoli_usati.status_veicolo = 'A') 
AND  1=1  
AND  1=1  
AND  1=1  
AND  1=1"; 

// status T A V U (D)




		
		//        AND n_veicoli.id_veicolo = ('302500')  
		
						$array = array();
						
					// $sql = "select * FROM  n_veicoli";
						
					$stmt = odbc_prepare($conn, $qUSATI);
					$result = odbc_execute($stmt); 
					
			

					// dd($numeroRow = odbc_num_fields($stmt));
					//nomi colonne /////////////////////////
					$nomeCol = array();
		
					for($n=1; $n<=85; $n++ ){
					$nomeCol[] = odbc_field_name($stmt , $n ); 
		
					} 
		
					//////////////////////////////////////
				  
					 // numero colonne
					$numeroRow = odbc_num_fields($stmt);  //85
		
					/////////////////////////////////////
		
		
						while (odbc_fetch_row($stmt)) {
							for ($i = 1; $i <= odbc_num_fields($stmt); $i++) {
								$array[] =  odbc_result($stmt, $i);
								
							}
							
						}
		
					//////////////////////////////////////
		
		
								
						$array = array_chunk($array, $numeroRow); 
						
						//numero array
						$numArray = count($array);
		
						for($k=0; $k < $numArray; $k++){
						$array[$k] = array_combine($nomeCol,$array[$k]);
		
						}
		
					//   $array[0] =  array_combine($nomeCol,$array[0]);
		
						return $array;
						
					
		
						adbc_close($conn);
		
		
		
					}
		
		

