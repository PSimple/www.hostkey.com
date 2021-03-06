<?php

/**
 * Получение групп зон
 *
 * @package Shop.Api.Domains
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.26
 */
class Shop_Api_Domains_ZoneAdvancedField extends Zero_Controller
{
    /**
     * Получение групп зон
     *
     * @return boolean flag статус выполнения
     */
    public function Action_GET()
    {
        /*
        --------------------------------------------------------------------
                      ///  WHMCS DOMAIN ADDITIONAL FIELDS  \\\
        --------------------------------------------------------------------

        This is where you can define the TLD specific fields required to
        register certain TLDs. Supported variables are:

          Name - key name used to reference field in modules (required)
          DisplayName - name displayed in client & admin interfaces
          LangVar - the language file variable to use if set
          Type - field type: text, dropdown, radio, tickbox (required)
          Size - the length of the text field
          Default - the default value the field should take
          Required - force entry - true/false

        --------------------------------------------------------------------
        */
        $additionaldomainfields = [];
// .US

        $additionaldomainfields[".us"][] = array("Name" => "Nexus Category", "LangVar" => "ustldnexuscat", "Type" => "dropdown", "Options" => "C11,C12,C21,C31,C32", "Default" => "C11",);
        $additionaldomainfields[".us"][] = array("Name" => "Info", "LangVar" => "us_info", "Type" => "display", "Default" =>
            "Nexus information is required for the registrants to ensure that only those individuals or organizations that have a substantive lawful connection to the US are permitted to register for usTLD domain names.<br><br>
			Possible values:
        <ul>
            <li><strong>C12</strong>: A permanent resident of the U.S. (a natural person).</li>
            <li><strong>C11</strong>: A U.S. citizen (a natural person).</li>
            <li><strong>C21</strong>: An organization entitled to register.</li>
			<li><strong>C31</strong>: A foreign organization entitled to register.</li>
            <li><strong>C32</strong>: An organization with office or facility in the U.S.</li>
        </ul>",);
        $additionaldomainfields[".us"][] = array("Name" => "Nexus Country", "LangVar" => "ustldnexuscountry", "Type" => "text", "Size" => "22", "Default" => "Two-digit country code", "Required" => true,);
        $additionaldomainfields[".us"][] = array("Name" => "Application Purpose", "LangVar" => "ustldapppurpose", "Type" => "dropdown", "Options" => "Business use for profit,Non-profit business,Club,Association,Religious Organization,Personal Use,Educational purposes,Government purposes", "Default" => "Business use for profit",);

// .UK

        $additionaldomainfields[".co.uk"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "uktldlegaltype", "Type" => "dropdown", "Options" => "Natural Person,UK Limited Company,UK Public Limited Company,UK Partnership,UK Limited Liability Partnership,Sole Trader,UK Registered Charity,UK Entity (other),Foreign Organization,Other foreign organizations,UK Industrial/Provident Registered Company,UK School,UK Government Body,UK Corporation by Royal Charter,UK Statutory Body,Non-UK Natural Person", "Default" => "Natural Person",);

        $additionaldomainfields[".co.uk"][] = array("Name" => "Company ID Number", "LangVar" => "uktldcompanyid", "Type" => "text", "Size" => "30", "Default" => "", "Required" => false,);
        $additionaldomainfields[".co.uk"][] = array("Name" => "Registrant Name", "LangVar" => "uktldregname", "Type" => "text", "Size" => "30", "Default" => "", "Required" => true,);
        $additionaldomainfields[".net.uk"] = $additionaldomainfields[".co.uk"];
        $additionaldomainfields[".org.uk"] = $additionaldomainfields[".co.uk"];
        $additionaldomainfields[".me.uk"] = $additionaldomainfields[".co.uk"];
        $additionaldomainfields[".plc.uk"] = $additionaldomainfields[".co.uk"];
        $additionaldomainfields[".ltd.uk"] = $additionaldomainfields[".co.uk"];
        $additionaldomainfields[".co.uk"][] = array("Name" => "WHOIS Opt-out", "LangVar" => "uktldwhoisoptout", "Type" => "tickbox",);
        $additionaldomainfields[".co.uk"][] = array("Name" => "Info", "LangVar" => "co.uk_info", "Type" => "display", "Default" =>
            "You have the right to opt out from having you address, and where applicable the address for service, published on the WHOIS. This option is only available if the registrant type is set as \"UK Natural Person\". Furthermore to qualify the domain name must not be used for any commercial activity and be unconnected with any business, trade or profession. This includes the display of any pay per click advertising on the site.",);
        $additionaldomainfields[".uk"] = $additionaldomainfields[".co.uk"];

// .CA

        $additionaldomainfields[".ca"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "catldlegaltype", "Type" => "dropdown", "Options" => "Corporation,Canadian Citizen,Permanent Resident of Canada,Government,Canadian Educational Institution,Canadian Unincorporated Association,Canadian Hospital,Partnership Registered in Canada,Trade-mark registered in Canada,Canadian Trade Union,Canadian Political Party,Canadian Library Archive or Museum,Trust established in Canada,Aboriginal Peoples,Legal Representative of a Canadian Citizen,Official mark registered in Canada", "Default" => "Corporation", "Description" => "Legal type of registrant contact",);
        $additionaldomainfields[".ca"][] = array("Name" => "CIRA Agreement", "LangVar" => "catldciraagreement", "Type" => "tickbox", "Description" => "Tick to confirm you agree to the CIRA Registration Agreement shown below.<br />You have read, understood and agree to the terms and conditions of the Registrant Agreement, and that CIRA may, from time to time and at its discretion, amend any or all of the terms and conditions of the Registrant Agreement, as CIRA deems appropriate, by posting a notice of the changes on the CIRA website and by sending a notice of any material changes to Registrant. You meet all the requirements of the Registrant Agreement to be a Registrant, to apply for the registration of a Domain Name Registration, and to hold and maintain a Domain Name Registration, including without limitation CIRA's Canadian Presence Requirements for Registrants, at: <a href=\"http://www.cira.ca/assets/Documents/Legal/Registrants/CPR.pdf\" target=\"_blank\"> www.cira.ca/assets/Documents/Legal/Registrants/CPR.pdf</a>. CIRA will collect, use and disclose your personal information, as set out in CIRA's Privacy Policy, at: <a href=\"http://www.cira.ca/assets/Documents/Legal/Registrants/privacy.pdf\" target=\"_blank\">www.cira.ca/assets/Documents/Legal/Registrants/privacy.pdf.</a>",);
        $additionaldomainfields[".ca"][] = array("Name" => "WHOIS Opt-out", "LangVar" => "catldwhoisoptout", "Type" => "tickbox", "Description" => "Tick to hide your contact information in CIRA WHOIS (only available to individuals).",);

// .ES

        $additionaldomainfields[".es"][] = array("Name" => "ID Form Type", "DisplayName" => "ID Type", "LangVar" => "estldidformtype", "Type" => "dropdown", "Options" => "Other Identification,Tax Identification Number,Tax Identification Code,Foreigner Identification Number", "Default" => "Other Identification",);
        $additionaldomainfields[".es"][] = array("Name" => "ID Form Number", "DisplayName" => "ID Number", "LangVar" => "estldidformnum", "Type" => "text", "Size" => "30", "Default" => "", "Required" => true,);
        $additionaldomainfields[".es"][] = array(
            "Name" => "Legal Form",
            "LangVar" => "estldlegalform",
            "Type" => "dropdown",
            "Options" => implode(
                ',',
                array(
                    '1|Individual',
                    '39|Economic Interest Grouping',
                    '47|Association',
                    '59|Sports Association',
                    '68|Professional Association',
                    '124|Savings Bank',
                    '150|Community Property',
                    '152|Community of Owners',
                    '164|Order or Religious Institution',
                    '181|Consulate',
                    '197|Public Law Association',
                    '203|Embassy',
                    '229|Local Authority',
                    '269|Sports Federation',
                    '286|Foundation',
                    '365|Mutual Insurance Company',
                    '434|Regional Government Body',
                    '436|Central Government Body',
                    '439|Political Party',
                    '476|Trade Union',
                    '510|Farm Partnership',
                    '524|Public Limited Company',
                    '554|Civil Society',
                    '560|General Partnership',
                    '562|General and Limited Partnership',
                    '566|Cooperative',
                    '608|Worker-owned Company',
                    '612|Limited Company',
                    '713|Spanish Office',
                    '717|Temporary Alliance of Enterprises',
                    '744|Worker-owned Limited Company',
                    '745|Regional Public Entity',
                    '746|National Public Entity',
                    '747|Local Public Entity',
                    '877|Others',
                    '878|Designation of Origin Supervisory Council',
                    '879|Entity Managing Natural Areas',
                )
            ),
            "Default" => "1|Individual",
        );
        $additionaldomainfields[".es"][] = array("Name" => "Info", "LangVar" => "es_info", "Type" => "display", "Default" =>
            "
        <ul>
            <li><strong>Tax Identification Number (NIF)</strong>: Select this option if you can provide us with either your Spanish National Personal ID.</li>
            <li><strong>Tax Identification Code (CIF)</strong>: Select this option if you can provide us with either your Spanish company VAT ID number.</li>
            <li><strong>Foreigner Identification Number (NIE)</strong>: Select this option if you can provide us with your Spanish resident alien ID number.</li>
			        </ul>",);

// .SG

        $additionaldomainfields[".sg"][] = array("Name" => "RCB Singapore ID", "DisplayName" => "RCB (Registry of Companies & Businesses) Singapore ID", "LangVar" => "sgtldrcbid", "Type" => "text", "Size" => "30", "Default" => "", "Required" => true,);
        $additionaldomainfields[".sg"][] = array("Name" => "Registrant Type", "LangVar" => "sgtldregtype", "Type" => "dropdown", "Options" => "Natural Person,Organisation", "Default" => "Natural Person",);
        $additionaldomainfields[".com.sg"] = $additionaldomainfields[".sg"];
        $additionaldomainfields[".edu.sg"] = $additionaldomainfields[".sg"];
        $additionaldomainfields[".net.sg"] = $additionaldomainfields[".sg"];
        $additionaldomainfields[".org.sg"] = $additionaldomainfields[".sg"];
        $additionaldomainfields[".per.sg"] = $additionaldomainfields[".sg"];

// .TEL

        $additionaldomainfields[".tel"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "teltldlegaltype", "Type" => "dropdown", "Options" => "Natural Person,Legal Person", "Default" => "Natural Person",);
        $additionaldomainfields[".tel"][] = array("Name" => "WHOIS Opt-out", "LangVar" => "teltldwhoisoptout", "Type" => "tickbox", "Description" => "Tick to hide your contact information in WHOIS (only available to natural person).",);

// .IT

        $additionaldomainfields[".it"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "ittldlegaltype", "Type" => "dropdown", "Options" => "Italian and foreign natural persons,Companies/one man companies,Freelance workers/professionals,Non-profit organizations,Public organizations,Other subjects,Non natural foreigners", "Default" => "Italian and foreign natural persons", "Description" => "Legal type of registrant",);
        $additionaldomainfields[".it"][] = array("Name" => "Tax ID", "LangVar" => "ittldtaxid", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true,);
        $additionaldomainfields[".it"][] = array("Name" => "Info", "LangVar" => "it_info", "Type" => "display", "Default" =>
            "In order to register a domain, you have to agree with the conditions of the <a href=\"http://www.nic.it/sites/default/files/docs/Registrar_Contract%202016-2019.pdf\" target=\"_blank\">Registrar Contract</a> and with the publication of your personal data.",);
        $additionaldomainfields[".it"][] = array("Name" => "Publish Personal Data", "LangVar" => "ittlddata", "Type" => "tickbox", "Description" => "You agree to the publication of your personal data.",);
        $additionaldomainfields[".it"][] = array("Name" => "Accept Section 3 of .IT registrar contract", "LangVar" => "ittldsec3", "Type" => "tickbox",);
        $additionaldomainfields[".it"][] = array("Name" => "Accept Section 5 of .IT registrar contract", "LangVar" => "ittldsec5", "Type" => "tickbox",);
        $additionaldomainfields[".it"][] = array("Name" => "Accept Section 6 of .IT registrar contract", "LangVar" => "ittldsec6", "Type" => "tickbox",);
        $additionaldomainfields[".it"][] = array("Name" => "Accept Section 7 of .IT registrar contract", "LangVar" => "ittldsec7", "Type" => "tickbox",);

// .DE

        $additionaldomainfields[".de"][] = array("Name" => "Tax ID", "LangVar" => "detldtaxid", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true,);
        $additionaldomainfields[".de"][] = array("Name" => "Address Confirmation", "LangVar" => "detldaddressconfirm", "Type" => "tickbox", "Description" => "Please tick to confirm you have a valid German address",);

// .AU

        $additionaldomainfields[".com.au"][] = array("Name" => "Registrant Name", "LangVar" => "autldregname", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true,);
        $additionaldomainfields[".com.au"][] = array("Name" => "Registrant ID", "LangVar" => "autldregid", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true,);
        $additionaldomainfields[".com.au"][] = array("Name" => "Registrant ID Type", "LangVar" => "autldregidtype", "Type" => "dropdown", "Options" => "ABN,ACN,Business Registration Number", "Default" => "ABN",);
        $additionaldomainfields[".com.au"][] = array("Name" => "Eligibility Name", "LangVar" => "autldeligname", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false,);
        $additionaldomainfields[".com.au"][] = array("Name" => "Eligibility ID", "LangVar" => "autldeligid", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false,);
        $additionaldomainfields[".com.au"][] = array("Name" => "Eligibility ID Type", "LangVar" => "autldeligidtype", "Type" => "dropdown", "Options" => ",Australian Company Number (ACN),ACT Business Number,NSW Business Number,NT Business Number,QLD Business Number,SA Business Number,TAS Business Number,VIC Business Number,WA Business Number,Trademark (TM),Other - Used to record an Incorporated Association number,Australian Business Number (ABN)", "Default" => "",);
        $additionaldomainfields[".com.au"][] = array("Name" => "Eligibility Type", "LangVar" => "autldeligtype", "Type" => "dropdown", "Options" => "Charity,Citizen/Resident,Club,Commercial Statutory Body,Company,Incorporated Association,Industry Body,Non-profit Organisation,Other,Partnership,Pending TM Owner  ,Political Party,Registered Business,Religious/Church Group,Sole Trader,Trade Union,Trademark Owner,Child Care Centre,Government School,Higher Education Institution,National Body,Non-Government School,Pre-school,Research Organisation,Training Organisation", "Default" => "Company",);
        $additionaldomainfields[".com.au"][] = array("Name" => "Eligibility Reason", "LangVar" => "autldeligreason", "Type" => "radio", "Options" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.,Close and substantial connection between the domain name and the operations of your Entity.", "Default" => "Domain name is an Exact Match Abbreviation or Acronym of your Entity or Trading Name.",);

        $additionaldomainfields[".net.au"] = $additionaldomainfields[".com.au"];
        $additionaldomainfields[".org.au"] = $additionaldomainfields[".com.au"];
        $additionaldomainfields[".asn.au"] = $additionaldomainfields[".com.au"];
        $additionaldomainfields[".id.au"] = $additionaldomainfields[".com.au"];

// .ASIA

        $additionaldomainfields[".asia"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "asialegaltype", "Type" => "dropdown", "Options" => "Natural Person,Corporation,Cooperative,Partnership,Government,Political Party,Society,Institution", "Default" => "Natural Person",);
        $additionaldomainfields[".asia"][] = array("Name" => "Identity Form", "DisplayName" => "ID Form", "LangVar" => "asiaidentityform", "Type" => "dropdown", "Options" => "Passport,Certificate,Legislation,Society Registry,Political Party Registry", "Default" => "Passport",);
        $additionaldomainfields[".asia"][] = array("Name" => "Identity Number", "DisplayName" => "ID Number", "LangVar" => "asiaidentitynumber", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true,);

// .PRO

        $additionaldomainfields[".pro"][] = array("Name" => "Profession", "LangVar" => "proprofession", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "Indicated professional association recognized by government body",);
        $additionaldomainfields[".pro"][] = array("Name" => "License Number", "LangVar" => "prolicensenumber", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, "Description" => "The license number of the registrant's credentials, if applicable.",);
        $additionaldomainfields[".pro"][] = array("Name" => "Authority", "DisplayName" => "Issuing Authority", "LangVar" => "proauthority", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, "Description" => "The name of the authority from which the registrant receives their professional credentials.",);
        $additionaldomainfields[".pro"][] = array("Name" => "Authority Website", "DisplayName" => "Issuing Authority Website", "LangVar" => "proauthoritywebsite", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, "Description" => "The URL to an online resource for the authority, preferably, a member search directory.",);

// .COOP

        $additionaldomainfields[".coop"][] = array("Name" => "Contact Name", "LangVar" => "coopcontactname", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "A sponsor is required to register .coop domains. Please enter the information here",);
        $additionaldomainfields[".coop"][] = array("Name" => "Contact Company", "LangVar" => "cooopcontactcompany", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "Contact Email", "LangVar" => "coopcontactemail", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "Address 1", "LangVar" => "coopaddress1", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "Address 2", "LangVar" => "coopaddress2", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "City", "LangVar" => "coopcity", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "State", "LangVar" => "coopstate", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "ZIP Code", "LangVar" => "coopzip", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);
        $additionaldomainfields[".coop"][] = array("Name" => "Country", "LangVar" => "coopcountry", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "Please enter your country code (eg. FR, IT, etc...)",);
        $additionaldomainfields[".coop"][] = array("Name" => "Phone CC", "LangVar" => "coopphonecc", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "Phone Country Code eg 1 for US & Canada, 44 for UK",);
        $additionaldomainfields[".coop"][] = array("Name" => "Phone", "LangVar" => "coopphone", "Type" => "text", "Size" => "20", "Default" => "", "Required" => true, "Description" => "",);

// .CN
        $additionaldomainfields[".cn"][] = array("Name" => "cnhosting", "DisplayName" => "Hosted in China?", "LangVar" => "cnhosting", "Type" => "tickbox");
        $additionaldomainfields[".cn"][] = array("Name" => "cnhregisterclause", "DisplayName" => "Agree to the .CN <a href=\"http://www1.cnnic.cn/PublicS/fwzxxgzcfg/201208/t20120830_35735.htm\" target=\"_blank\">Register Agreement</a>", "LangVar" => "ittldsec3", "Type" => "tickbox", "Required" => true,);

// .FR

        $additionaldomainfields[".fr"][] = array("Name" => "Legal Type", "DisplayName" => "Legal Form", "LangVar" => "fr_legaltype", "Type" => "dropdown", "Options" => "Natural Person,Company", "Default" => "Natural Person",);
        $additionaldomainfields[".fr"][] = array("Name" => "Info", "LangVar" => "fr_info", "Type" => "display", "Default" =>
            ".fr domains have different required values depending on your nationality and type of registration: 
        <ul>
            <li><strong>French Natural Persons</strong>: Please provide your \"Birthdate\", \"Birthplace City\", \"Birthplace Country\", and \"Birthplace Postcode\".</li>
            <li><strong>EU Non-French Natural Persons</strong>: Please provide your \"Birthdate\".</li>
            <li><strong>French Companies</strong>: Please provide the \"Birthdate\", \"Birthplace City\", \"Birthplace Country\", and \"Birthplace Postcode\" for the owner contact, along with your SIRET number.</li>
            <li><strong>EU Non-French Companies</strong>: Please provide the company \"DUNS Number\", and the \"Birthdate\" of the Owner Contact.</li>
        </ul>
        <em>Client contact information must be within the EU or else registration will fail.</em>",);
        $additionaldomainfields[".fr"][] = array("Name" => "Birthdate", 'LangVar' => 'fr_indbirthdate', "Type" => "text", "Size" => "16", "Default" => "1969-10-29", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "Birthplace City", 'LangVar' => 'fr_indbirthcity', "Type" => "text", "Size" => "25", "Default" => "", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "FR", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');
        $additionaldomainfields[".fr"][] = array("Name" => "Birthplace Postcode", 'LangVar' => 'fr_indbirthpostcode', "Type" => "text", "Size" => "6", "Default" => "", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "SIRET Number", 'LangVar' => 'fr_cosiret', "Type" => "text", "Size" => "50", "Default" => "", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "DUNS Number", 'LangVar' => 'fr_coduns', "Type" => "text", "Size" => "50", "Default" => "", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "Info", "LangVar" => "fr_duns_info", "Type" => "display", "Default" =>
            "The <a href=\"https://www.dandb.com/product/companyupdate/companyupdateLogin?execution=e2s1\" target=\"_blank\">DUNS</a> number is a nine-digit number, issued by Dun Bradstreet. DUNS is the abbreviation of Data Universal Numbering System. Companies with a valid DUNS number are still obliged having their head office in the territory of the European Union. The DUNS number can be provided using this extension.",);
        $additionaldomainfields[".fr"][] = array("Name" => "VAT Number", 'LangVar' => 'fr_vat', "Type" => "text", "Size" => "50", "Default" => "", "Required" => false);
        $additionaldomainfields[".fr"][] = array("Name" => "Trademark Number", 'LangVar' => 'fr_trademarknumber', "Type" => "text", "Size" => "50", "Default" => "", "Required" => false);

// .QUEBEC
        $additionaldomainfields[".quebec"][] = array("Name" => "Intended Use", 'LangVar' => 'quebec_intendeduse', "Type" => "text", "Size" => "50", "Default" => "", "Required" => true);
        $additionaldomainfields[".quebec"][] = array("Name" => "Info", "LangVar" => "quebec_info", "Type" => "display", "Default" => "Intended Use field limited to 2048 characters by the API.  The contents of the field above will be truncated if longer than that when sent to the registrar.");

// .RE
        $additionaldomainfields[".re"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "RE", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');

// .PM
        $additionaldomainfields[".pm"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "PM", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');

// .TF
        $additionaldomainfields[".tf"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "TF", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');

// .WF
        $additionaldomainfields[".wf"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "WF", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');

// .YT
        $additionaldomainfields[".yt"][] = array("Name" => "Birthplace Country", "Type" => "text", "Size" => "2", "Default" => "YT", "Required" => false, "Description" => 'Please, enter your birth country code (use <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166-1 alpha 2</a>)');


// .SE
        $additionaldomainfields[".se"][] = array("Name" => "Personal or organisation number", "DisplayName" => "Personal or organization number", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, 'Description' => 'Corporate identity number or personal identification number (for non Swedish, any other unique identification number can be used instead)');
        $additionaldomainfields[".se"][] = array("Name" => "Info", "LangVar" => "se_info", "Type" => "display", "Default" =>
            "Corporate identity number or personal identification number (for non Swedish, any other unique identification number can be used instead).",);
        $additionaldomainfields[".se"][] = array("Name" => "Vat number", "DisplayName" => "VAT Number", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, 'Description' => 'VAT registration number (only for foreign legal entities within the EU who are registered to pay VAT)');

// .NU
        $additionaldomainfields[".nu"][] = array("Name" => "Personal or organisation number", "DisplayName" => "Personal or organization number", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, 'Description' => 'Corporate identity number or personal identification number (for non Swedish, any other unique identification number can be used instead)');
        $additionaldomainfields[".nu"][] = array("Name" => "Info", "LangVar" => "nu_info", "Type" => "display", "Default" =>
            "Corporate identity number or personal identification number (for non Swedish, any other unique identification number can be used instead).",);
        $additionaldomainfields[".nu"][] = array("Name" => "Vat number", "DisplayName" => "VAT Number", "Type" => "text", "Size" => "20", "Default" => "", "Required" => false, 'Description' => 'VAT registration number (only for foreign legal entities within the EU who are registered to pay VAT)');

        Zero_App::ResponseJson200($additionaldomainfields);
        return true;
    }

    /**
     * Фабричный метод по созданию контроллера.
     *
     * @param array $properties входные параметры плагина
     * @return Shop_Api_Domains_ZoneAdvancedField
     */
    public static function Make($properties = [])
    {
        $Controller = new self();
        foreach ($properties as $property => $value) {
            $Controller->Params[$property] = $value;
        }
        return $Controller;
    }
}
