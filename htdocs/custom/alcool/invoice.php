<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) <2016>  <jamelbaz@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


// Load Dolibarr environment
if (false === (@include '../main.inc.php')) {  // From htdocs directory
	require '../../main.inc.php'; // From "custom" directory
}
require_once DOL_DOCUMENT_ROOT . '/compta/facture/class/facture.class.php';
require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php';



require_once DOL_DOCUMENT_ROOT . '/core/lib/invoice.lib.php';
$action = GETPOST('action');

$langs->load("companies");

// Security check
$id = GETPOST('id','int');
$soc_id = GETPOST('soc_id','int');
$montant = GETPOST('montant');

$object = new Facture($db);
$prd = new Product($db);

if($id) $ret = $object->fetch($id);
$result = $object->getLinesArray();

$societe = new Societe($db);

if($action == 'calcul'){
	// var_dump(date('Y-m-d', $object->date));die;
	$date_f = date('Y-m-d', $object->date);
	// Je cherche le pourcentage applicable période de facture
	$sql = "SELECT";
	$sql.= " * ";
	$sql.= " FROM ".MAIN_DB_PREFIX."alcool_tax  ";		
	$sql.= " where start_date <= '" . $date_f ."' and end_date >= '" . $date_f ."' "; 
	// echo $sql;
	$resql = $db->query($sql);
	if ($resql) {
		if ($db->num_rows($resql)) {
			$obj = $db->fetch_object($resql);
			
			foreach($object->lines as $k => $v){
				$v->fetch_optionals($v->id);
				if(!empty($v->fk_product)){
				
				
					$prd->fetch($v->fk_product);
					// var_dump();continue;
					
					if(empty($v->array_options['options_m_tx_alc']) && empty($v->array_options['options_m_tx_sec'])){
						// var_dump($v->fk_product);die;
						$veh = GETPOST('veh');
						$nbrveh = GETPOST('nbrveh');					
							
							$m_tx_alc = $prd->array_options['options_prc_alc']/100 * $obj->tax_alc;
							$m_tx_sec = $prd->array_options['options_prc_alc']/100 * $obj->tax_sec;
							
							$sql = 'INSERT INTO ' . MAIN_DB_PREFIX . 'facturedet_extrafields (';
							$sql .= ' fk_object,';
							$sql .= ' m_tx_alc,';
							$sql .= ' m_tx_sec';
							$sql .= ') VALUES (';
							$sql .= ' \'' . $v->id . '\',';
							$sql .= ' ' . $m_tx_alc . ',';
							$sql .= ' ' . $m_tx_sec . '';
							$sql .= ')';
							// echo $sql;
							$db->begin();

							$resql = $db->query($sql);
							$db->commit();

					}
				}
				
			}
			
			
		}
	}
	
	// var_dump($object->lines);
	
	// die;
	header('Location: invoice.php?id='.$id);
	exit;
}

llxHeader('', $langs->trans('Alcool'), 'EN:Customers_Invoices|FR:Factures_Clients|ES:Facturas_a_clientes');

	$head = facture_prepare_head($object);

    dol_fiche_head($head, 'Alcool', $langs->trans('InvoiceCustomer'), 0, 'Alcool');
	// Show global modifiers

	print '<div class="div-table-responsive-no-min">';
	print '<table id="tablelines" class="noborder noshadow" width="100%">';

	// Show object lines
	if (! empty($object->lines))
		$ret = $object->printObjectLines($action, $mysoc, $soc, $lineid, 1);

	

	print "</table>\n";
	print "</div>";
	print '<div class="tabsAction"><div class="inline-block divButAction"><a class="butAction" href="?id='.$id.'&action=calcul">Calculer Tx</a></div>'; 

	dol_fiche_end();
llxFooter();
$db->close();