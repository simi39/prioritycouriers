<?php

 foreach ($BookingItemDetailsData as $key => $val) {
               $items_des_str .= '<td class="w_50" valign="top"> '.$val["quantity"] .' &#64; '. $val["item_weight"] .'kg '. $val["length"] . 'cm x '. $val["width"] .'cm x '. $val["height"] .'cm <br></td>';
  }

$html_commercial_invoice='<style type="text/css">
#outlook a {padding:0;}body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}.ExternalClass {width:100%;}
.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important; color:#333; font-size: 13px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;}img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
a img {border:none;}
.image_fix {display:block;}p {margin: 1em 0;}
h1, h2, h3, h4, h5, h6 {color: #686868 !important; font-family: "Open Sans", sans-serif; font-weight: normal !important;}h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
  color: red !important;
 }h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
  color: purple !important;
}table td {border-collapse: collapse; width:100%}
table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100%}
a {color: #72c02c; text-decoration:none;}

  a[href^="tel"], a[href^="sms"] {
        text-decoration: none;
        color: blue; /* or whatever your want */
        pointer-events: none;
        cursor: default;
      }

  .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
        text-decoration: default;
        color: orange !important;
        pointer-events: auto;
        cursor: default;
      }
.w_100 {
  width:100%;
}
.w_90 {
  width:90%;
}
.w_80 {
  width:80%;
}
.w_70 {
  width:70%;
}
.w_65 {
  width:65%;
}
.w_60 {
  width:60%;
}
.w_55 {
  width:55%;
}
.w_50 {
  width:50%;
}
.w_45 {
  width:45%;
}
.w_40 {
  width:40%;
}
.w_35 {
  width:35%;
}
.w_33 {
  width:33.3%;
}
.w_30 {
  width:30%;
}
.w_25 {
  width:25%;
}
.w_20 {
  width:20%;
}
.margin_bottom_30 {
  margin-bottom: 30px;
}
.margin_bottom_20 {
  margin-bottom: 20px;
}
ul {
  list-style-type: none;
  padding-left:0;
}
ul li {
  padding-bottom:4px;
}
h2 {
  font-size: 31.5px;
  margin-bottom: 15px;
  text-align:center;
  }
.headline h3, .headline h4 {
  border-bottom: 2px solid #72c02c;
  }
.no_border-b {
  border-bottom:none !important;
  margin-bottom: 0;
}
.bg-light {
  padding:10px 15px;
  border-radius:3px;
  margin-bottom:10px;
  background:#fcfcfc;
  border:solid 1px #fcfcfc;
  }
.bg-light:hover {
  border:solid 1px #e5e5e5;
  }
blockquote {
  padding: 0 0 0 15px;
  margin: 0 0 20px;
  border-left: 5px solid #eee;
  font-size: 17.5px;
  font-weight: 300;
  line-height: 1.25;
  }
blockquote:hover {
  border-left: 5px solid #72c02c;
  }
blockquote p {
  color: #555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  }
.standard_font {
  padding: 0 0 0 15px;
  margin: 0 0 20px;
  font-size: 17.5px;
  font-weight: 300;
  line-height: 1.25;
  color: #555;
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
}
.justy {
  text-align: justify;
  }
.my_green {
  color: #72c02c !important;
  }
.muted {
  color: #999;
  }
.text-right {
  text-align:right;
  }
.pull-right {
  text-align:right;
  float:right;
  }
.border_bottom {
  background: transparent;
  color: transparent;
  border-left: none;
  border-right: none;
  border-top: none;
  border-bottom: 2px dashed #72c02c;
  }
.footer {
  margin-top: 40px;
  padding: 20px 10px;
  background: #585f69;
  color: #dadada;
  }
.footer h4, .footer h3 {
  color: #e4e4e4 !important;
  background: none;
  text-shadow: none;
  font-weight:lighter !important;
  }
.copyright {
  font-size: 12px;
  padding: 5px 10px;
  background: #3e4753;
  border-top: solid 1px #777;
  color: #dadada;
  }
.address {
  display: block;
  margin-bottom: 20px;
  font-style:normal;
  line-height: 20px;
  font-size: 13px;
  }
.social_googleplus {
  background: url(http://prioritycouriers.com.au/assets/img/icons/social/googleplus.png) no-repeat;
  width: 28px;
  height: 28px;
  display: block;
  }
.social_googleplus:hover {
  background-position: 0px -38px;
  }
.receipt {
  font-size:10px;
}
.headline {
  margin: 5px 0 10px 0;
  }
.lead {
  font-size: 16px;
  font-weight: 100;
  line-height: 35px;
  }
.my_bigger_font,
.my_bigger_font td {
  font-size: 10px;
  font-weight: 200;
  line-height: 1;
  }
.pad_main {
  padding: 10px 10px 5px 10px;
}
.pad_side {
  padding: 0 10px 0 10px;
}
.pad_3 td {
  padding: 3px;
}
.pad_fee td,
.pad_address {
  padding: 3px;
}
.fee_dashed {
  border-bottom: 2px dashed #72c02c;
}
.fee_above_dashed {
  padding-top:10px !important;
}
</style>

<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
  <tr>
    <td>
      <table cellpadding="0" cellspacing="0" border="0" align="center" class="w_90">
        <tr>
          <td valign="top">
            <table cellpadding="0" cellspacing="1" border="0" align="center">
              <tr>
                <td class="pad_main" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center" class="headline">
                    <tr>
                      <td class="pad_side" valign="top">
                        <h2>Commercial Invoice</h2>
                      </td>
                    </tr>
                  </table>
                  <table  cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_30">
                    <tr>
                      <td class="w_33" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_45" valign="top">Date:</td>
                            <td class="w_50" valign="top">'.date("d-M-Y").'</td>
                          </tr>
                        </table>
                      </td>
                      <td class="w_33" valign="top"></td>
                      <td class="w_33" valign="top">
                        <table cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_45" valign="top">Invoice#</td>
                            <td class="w_50" valign="top">PC'.$autoId.'</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td class="pad_main" valign="top">
            <table cellpadding="0" cellspacing="0" border="0" align="center">
              <tr>
                <td class="w_50" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <td valign="top">
                        <div class="headline w_90">
                          <h3>Shipper</h3>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table class="pad_3" cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_30" valign="top">Company:</td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_company_name"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Address:</td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_1"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top"></td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_2"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top"></td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_address_3"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Suburb/City:</td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["sender_suburb"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">State:</td>
                            <td class="w_65" valign="top">'. strtoupper($BookingDetailsDataVal["sender_state"]).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Postcode:</td>
                            <td class="w_65" valign="top">'.$BookingDetailsDataVal["sender_postcode"].'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Country:</td>
                            <td class="w_65" valign="top">'.$senderCountry.'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Contact Name:</td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["sender_first_name"])).'&nbsp;'. ucwords(strtolower($BookingDetailsDataVal["sender_surname"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Contact Nr:</td>
                            <td class="w_65" valign="top">'.$BookingDetailsDataVal["sender_area_code"]." ". $BookingDetailsDataVal["sender_contact_no"].'</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td class="w_50" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <td valign="top">
                        <div class="headline w_90">
                          <h3>Consignee</h3>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table class="pad_3" cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_30" valign="top">Company:</td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_company_name"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Address:</td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_address_1"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top"></td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_address_2"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top"></td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_address_3"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Suburb/City:</td>
                            <td class="w_65" valign="top">'. ucwords(strtolower($BookingDetailsDataVal["reciever_suburb"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">State:</td>
                            <td class="w_65" valign="top">'. $BookingDetailsDataVal["reciever_state"].'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Postcode:</td>
                            <td class="w_65" valign="top">'. $BookingDetailsDataVal["reciever_postcode"].'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Country:</td>
                            <td class="w_65" valign="top">'.$recieverCountry.'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Contact Name:</td>
                            <td class="w_65" valign="top">'.ucwords(strtolower($BookingDetailsDataVal["reciever_firstname"])).'&nbsp;'.ucwords(strtolower($BookingDetailsDataVal["reciever_surname"])).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Contact Nr:</td>
                            <td class="w_65" valign="top">'.$BookingDetailsDataVal["reciever_area_code"]." ". ucwords($BookingDetailsDataVal["reciever_contact_no"]).'</td>
                          </tr>
                          <tr>
                            <td class="w_30" valign="top">Email:</td>
                            <td class="w_65" valign="top">'.$BookingDetailsDataVal["[reciever_email]"].'</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="w_50" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <td valign="top">
                        <div class="headline w_90">
                          <h3>Shipping Details</h3>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table class="pad_3" cellpadding="0" cellspacing="0" border="0" align="center">
                          <tr>
                            <td class="w_45" valign="top">Consignment Note No.:</td>
                            <td class="w_50" valign="top">'.$CCConnote.'</td>
                          </tr>
                          <tr>
                            <td class="w_45" valign="top">No. of Itmes:</td>
                            <td class="w_50" valign="top">'. $BookingDetailsDataVal["total_qty"].' pcs</td>
                          </tr>
                          <tr>
                            <td class="w_45" valign="top">Total Weight:</td>
                            <td class="w_50" valign="top">'. $BookingDetailsDataVal["total_weight"].' kg</td>
                          </tr>
                          <tr>
                            <td class="w_45" valign="top">Chargeable Weight:</td>
                            <td class="w_50" valign="top">'. $BookingDetailsDataVal["chargeable_weight"].' kg</td>
                          </tr>
                          <tr>
                            <td class="w_45" valign="top">Volumetric Weight :</td>
                            <td class="w_50" valign="top">'. $BookingDetailsDataVal["volumetric_weight"].' kg</td>
                          </tr>
                          <tr>
                            <td class="w_45" valign="top">Dimensions :</td>
                            '.$items_des_str.'
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
                <td class="w_50" valign="top"></td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td class="w_50" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <th>Goods Description</th>
                    </tr>
                    <tr>
                      <td valign="top">'. $BookingDetailsDataVal["description_of_goods"].'</td>
                    </tr>
                  </table>
                </td>
                <td class="w_25" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <th>Currency Code</th>
                    </tr>
                    <tr>
                      <td valign="top">'. $BookingDetailsDataVal["currency_codes"].'</td>
                    </tr>
                  </table>
                </td>
                <td class="w_25" valign="top">
                  <table cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                      <th>Customs Value</th>
                    </tr>
                    <tr>
                      <td valign="top">'. $BookingDetailsDataVal["values_of_goods"].'</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td class="w_70" valign="top"></td>
                <td class="w_30" valign="top" class="my_bigger_font pad_fee">Total Invoice Value: '. $BookingDetailsDataVal["total_new_charge"].'</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td>Reason for Export '. $BookingDetailsDataVal["export_reason"].'</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td>I declare that the information  is true and correct to the best of my knowledge and the goods are of AUSTRALIA origin.</td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td>We, '. ucwords(strtolower($BookingDetailsDataVal["sender_company_name"])).' certify the particulars and quantity of the goods specified in this document are the goods which are submitted for the clearance for export out of AUSTRALIA.
                </td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center" class="margin_bottom_20">
              <tr>
                <td>Designation of Authorised Signatory
                </td>
              </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" align="center">
              <tr>
                <td>Signature / Stamp
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>';
?>
