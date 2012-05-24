<h4><b>This is to certify that the Grave Number:</b> &nbsp; <?php echo $amGranteeGraveDetails[0]['grave_number'];?></h4>
<p>
	Is registered in the records of the Trust as the current holder of the exclusive<br />
	Right of Burial Licence in relation to the burial place below
</p>

<table width="100%" cellpadding="3" cellspacing="0" border="01">
	<tr>
		<td>
			<b>Grantee</b>
		</td>
		<td>
			<b>Section</b>
		</td>
		<td>
			<b>Status</b>
		</td>
		<td>
			<b>Date of Purchase</b>
		</td>
	</tr>
	<?php foreach( $amGranteeGraveDetails[0]['Grantee'] as $asValues):?>
		<tr>
			<td>
				<?php 
					echo $ssGranteeName = ( $asValues['GranteeDetails']['title'] != '' ) ? $asValues['GranteeDetails']['title'].'&nbsp;'.$asValues['GranteeDetails']['grantee_name'] : $asValues['GranteeDetails']['grantee_name'];
				?>
			</td>
			<td>
				<?php echo ($amGranteeGraveDetails[0]['section_name'] != '') ? $amGranteeGraveDetails[0]['section_name'] : 'N/A';?>
			</td>
			<td>
				<?php echo $amGranteeGraveDetails[0]['grave_status'];?>
			</td>
			<td>
				<?php 
					list($snYear,$snMonth,$snDay) = explode('-',$asValues['date_of_purchase']);
					echo $snDay.'-'.$snMonth.'-'.$snYear;
				?>
			</td>
		</tr>
	<?php endforeach;?>
</table>
<div class="clearb">&nbsp;</div>
subject to the terms and conditions of the Crown Lands(General Reserve) By-Laws 2011 and the Rookwood Anglican and General Cemetery Trusts Guidelines for Sale of Graves 2009. (see below).

<h4><b>for the Trustees: ...............................................................................................................................................</b></h4>

<h4><b>Signature of holder ...........................................................................................................................................</b></h4>

<h4><b>Signature of witness .........................................................................................................................................</b></h4>

<h4><b>Note:</b></h4>

<p>By signing this Burial Licence, I/We understand and accept the conditions below 
  and agree to comply with these conditions. I/We acknowledge that we have 
  received a copy of the Crown Lands (General Reseve) By-Laws 2011 and the
  Rookwood Anglican and General Trusts Cemetery Guidelines and Policies. <br /><br />
  It is the reponsibility of the holder of this Licence Certificate to advise the
  Anglican & General Cemetery Trusts of any changes of address that may occur. <br /><br />
  The Burial Licence cannot be traded or sold to a third party outside the family.
  The Trust may refuse to grant, transfer or renew a Burial Licence if in the Trusts
  opinios, the granting, transfer or renewal would tend to create a monopoly or
  encourage dealings in burial licences. <br /><br />
  An appliation for the tranfer or renewal of a Burial Licence must be in the form
  approved by the Trust and accompanied by the appropriate fees. </p>
