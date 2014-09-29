<?php

namespace OmelettesDoctrineDeveloperFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OmelettesDoctrine\Document as OmDoc;

class LoadLocaleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->loadCountries($manager);
    }
    
    public function loadCountries(ObjectManager $manager)
    {
        $countryData = array(
            // Countries A
            "AD" => "Andorra",
            "AE" => "United Arab Erimates",
            "AF" => "Afghanistan",
            "AG" => "Antigua and Barbuda",
            "AI" => "Anguilla",
            "AL" => "Albania",
            "AM" => "Armenia",
            "AO" => "Angola",
            "AQ" => "Antarctica",
            "AR" => "Argentina",
            "AS" => "American Samoa",
            "AT" => "Austria",
            "AU" => "Australia",
            "AW" => "Aruba",
            "AX" => "Åland Islands",
            "AZ" => "Azerbaijan",
            
            // Countries B
            "BA" => "Bosnia and Herzegovina",
            "BB" => "Barbados",
            "BD" => "Bangladesh",
            "BE" => "Belgium",
            "BF" => "Burkina Faso",
            "BG" => "Bulgaria",
            "BH" => "Bahrain",
            "BI" => "Burundi",
            "BJ" => "Benin",
            "BL" => "Saint Barthélemy",
            "BM" => "Bermuda",
            "BN" => "Brunei",
            "BO" => "Bolivia",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BR" => "Brazil",
            "BS" => "Bahamas",
            "BT" => "Bhutan",
            "BV" => "Bouvet Island",
            "BW" => "Botswana",
            "BY" => "Belarus",
            "BZ" => "Belize",
            
            // Countries C
            "CA" => "Canada",
            "CC" => "Cocos (Keeling) Islands",
            "CD" => "Congo, Democratic Republic of",
            "CF" => "Central African Republic",
            "CG" => "Congo",
            "CH" => "Switzerland",
            "CI" => "Côte d'Ivoire",
            "CK" => "Cook Islands",
            "CL" => "Chile",
            "CM" => "Cameroon",
            "CN" => "China",
            "CO" => "Colombia",
            "CR" => "Costa Rica",
            "CU" => "Cuba",
            "CV" => "Cape Verde",
            "CW" => "Curaçao",
            "CX" => "Christmas Island",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            
            // Countries D
            "DE" => "Germany",
            "DJ" => "Djibouti",
            "DK" => "Denmark",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "DZ" => "Algeria",
            
            // Countries E
            "EC" => "Ecuador",
            "EE" => "Estonia",
            "EG" => "Egypt",
            "EH" => "Western Sahara",
            "ER" => "Eritrea",
            "ES" => "Spain",
            "ET" => "Ethiopia",
            
            // Countries F
            "FI" => "Finland",
            "FJ" => "Fiji",
            "FK" => "Falkland Islands",
            "FM" => "Micronesia",
            "FO" => "Faroe Islands",
            "FR" => "France",
            
            // Countries G
            "GA" => "Gabon",
            "GB" => "United Kingdom",
            "GD" => "Grenada",
            "GE" => "Georgia",
            "GF" => "French Guiana",
            "GG" => "Guernsey",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GL" => "Greenland",
            "GM" => "Gambia",
            "GN" => "Guinea",
            "GP" => "Guadaloupe",
            "GQ" => "Equatorial Guinea",
            "GR" => "Greece",
            "GS" => "South Georgia and the South Sandwich Islands",
            "GT" => "Guatemala",
            "GU" => "Guam",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            
            // Countries H
            "HK" => "Hong Kong",
            "HM" => "Heard Island and McDonald Islands",
            "HN" => "Honduras",
            "HR" => "Croatia",
            "HT" => "Haiti",
            "HU" => "Hungary",
            
            // Countries I
            "ID" => "Indonesia",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IM" => "Isle of Man",
            "IN" => "India",
            "IO" => "Diego Garcia",
            "IQ" => "Iraq",
            "IR" => "Iran",
            "IS" => "Iceland",
            "IT" => "Italy",
            
            // Countries J
            "JE" => "Jersey",
            "JM" => "Jamaica",
            "JO" => "Jordan",
            "JP" => "Japan",
            
            // Countries K
            "KE" => "Kenya",
            "KG" => "Kyrgyzstan",
            "KH" => "Cambodia",
            "KI" => "Kiribati",
            "KM" => "Comoros",
            "KN" => "Saint Kitts and Nevis",
            "KP" => "Korea, North",
            "KR" => "Korea, South",
            "KW" => "Kuwait",
            "KY" => "Cayman Islands",
            "KZ" => "Kazakhstan",
            
            // Countries L
            "LA" => "Laos",
            "LB" => "Lebanon",
            "LC" => "Saint Lucia",
            "LI" => "Liechtenstein",
            "LK" => "Sri Lanka",
            "LR" => "Liberia",
            "LS" => "Lesotho",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "LV" => "Latvia",
            "LY" => "Libya",
            
            // Countries M
            "MA" => "Morocco",
            "MC" => "Monaco",
            "MD" => "Moldova",
            "ME" => "Montenegro",
            "MF" => "Saint Martin",
            "MG" => "Madagasgar",
            "MH" => "Marshall Islands",
            "MK" => "Macedonia",
            "ML" => "Mali",
            "MM" => "Myanmar",
            "MN" => "Mongolia",
            "MO" => "Macao",
            "MP" => "Northern Mariana Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MS" => "Montserrat",
            "MT" => "Malta",
            "MU" => "Mauritius",
            "MV" => "Maldives",
            "MW" => "Malawi",
            "MX" => "Mexico",
            "MY" => "Malaysia",
            "MZ" => "Mozambique",
            
            // Countries N
            "NA" => "Namibia",
            "NC" => "New Caledonia",
            "NE" => "Niger",
            "NF" => "Norfolk Island",
            "NG" => "Nigeria",
            "NI" => "Nicaragua",
            "NL" => "Netherlands",
            "NO" => "Norway",
            "NP" => "Nepal",
            "NR" => "Nauru",
            "NU" => "Niue",
            "NZ" => "New Zealand",
            
            // Countries O
            "OM" => "Oman",
            
            // Countries P
            "PA" => "Panama",
            "PE" => "Peru",
            "PF" => "French Polynesia",
            "PG" => "Papua New Guinea",
            "PH" => "Philippines",
            "PK" => "Pakistan",
            "PL" => "Poland",
            "PM" => "Saint Pierre and Miquelon",
            "PN" => "Pitcairn",
            "PR" => "Puerto Rico",
            "PS" => "Palestine",
            "PT" => "Portugal",
            "PW" => "Palau",
            "PY" => "Paraguay",
            
            // Countries Q
            "QA" => "Qatar",
            
            // Countries R
            "RE" => "Réunion",
            "RO" => "Romania",
            "RS" => "Serbia",
            "RU" => "Russia",
            "RW" => "Rwanda",
            
            // Countries S
            "SA" => "Saudia Arabia",
            "SB" => "Solomon Islands",
            "SC" => "Seychelles",
            "SD" => "Sudan",
            "SE" => "Sweden",
            "SG" => "Singapore",
            "SH" => "Saint Helena",
            "SI" => "Slovenia",
            "SJ" => "Svalbard and Jan Mayen",
            "SK" => "Slovakia",
            "SL" => "Sierra Leone",
            "SM" => "San Marino",
            "SN" => "Senegal",
            "SO" => "Somalia",
            "SR" => "Suriname",
            "SS" => "South Sudan",
            "ST" => "Sao Tome and Principle",
            "SV" => "El Salvador",
            "SX" => "Sint Maarten",
            "SY" => "Syria",
            "SZ" => "Swaziland",
            
            // Countries T
            "TC" => "Turks and Caicos",
            "TD" => "Chad",
            "TF" => "French Southern Territories",
            "TG" => "Togo",
            "TH" => "Thailand",
            "TJ" => "Tajikistan",
            "TK" => "Tokelau",
            "TL" => "Timor-Leste",
            "TM" => "Turkmenistan",
            "TN" => "Tunisia",
            "TO" => "Tonga",
            "TR" => "Turkey",
            "TT" => "Trinidad and Tobago",
            "TV" => "Tuvalu",
            "TW" => "Taiwan",
            "TZ" => "Tanzania",
            
            // Countries U
            "UA" => "Ukraine",
            "UG" => "Uganda",
            "UM" => "United States Minor Outlying Islands",
            "US" => "United States",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            
            // Countries V
            "VA" => "Vatican City",
            "VC" => "Saint Vincent and the Grenadines",
            "VE" => "Venezuela",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "VN" => "Viet Nam",
            "VU" => "Vanuatu",
            
            // Countries W
            "WF" => "Wallis and Futuna",
            "WS" => "Samoa",
            
            // Countries Y
            "YE" => "Yemen",
            "YT" => "Mayotte",
            
            // Countries Z
            "ZA" => "South Africa",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
        );
        
        foreach ($countryData as $code => $name) {
            $country = new OmDoc\LocaleCountry();
            $country->setCode($code);
            $country->setName($name);
            
            $manager->persist($country);
        }
        
        $manager->flush();
    }
    
}