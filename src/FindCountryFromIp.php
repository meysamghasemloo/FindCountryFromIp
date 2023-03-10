<?php

namespace Meysam\FindCountryFromIP;

class FindCountryFromIp
{


    public static function getCountryCode($ip)
    {

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // Convert IP to binary format
        $binaryIp = inet_pton($ip);

        // Check if it's IPv4 or IPv6
        if (strlen($binaryIp) == 4) {
            // IPv4
            $code = self::getCountryCodeIPv4($binaryIp);
        } elseif (strlen($binaryIp) == 16) {
            // IPv6
            $code = self::getCountryCodeIPv6($binaryIp);
        } else {
            // Invalid IP format
            return false;
        }

        // Return country code in ISO 3166-1 format
        return $code;
    }

    private static function getCountryCodeIPv4($binaryIp)
    {
        // Load the IPv4 ranges file
        $ipv4Ranges = file_get_contents(__DIR__ . '/DB/ipv4.csv');
        $ranges = explode("\n", $ipv4Ranges);

        // Binary search for the IP address range
        $start = 0;
        $end = count($ranges) - 1;
        while ($start <= $end) {
            $mid = intval(($start + $end) / 2);
            $range = explode(',', $ranges[$mid]);
            $rangeStart = inet_pton($range[0]);
            $rangeEnd = inet_pton($range[1]);
            if ($binaryIp >= $rangeStart && $binaryIp <= $rangeEnd) {

                return $range[2];
            } elseif ($binaryIp < $rangeStart) {
                $end = $mid - 1;
            } else {
                $start = $mid + 1;
            }
        }

        // IP address not found in ranges file
        return false;
    }

    private static function getCountryCodeIPv6($binaryIp)
    {
        // Load the IPv6 ranges file
        $ipv6Ranges = file_get_contents(__DIR__ . '/DB/ipv6.csv');
        $ranges = explode("\n", $ipv6Ranges);

        // Binary search for
        // Convert IPv6 address to hexadecimal format
        $hexIp = bin2hex($binaryIp);

        // Binary search for the IP address range
        $start = 0;
        $end = count($ranges) - 1;
        while ($start <= $end) {
            $mid = intval(($start + $end) / 2);
            $range = explode(',', $ranges[$mid]);
            $rangeStart = str_replace(':', '', $range[0]);
            $rangeEnd = str_replace(':', '', $range[1]);
            if ($hexIp >= $rangeStart && $hexIp <= $rangeEnd) {
                return $range[2];
            } elseif ($hexIp < $rangeStart) {
                $end = $mid - 1;
            } else {
                $start = $mid + 1;
            }
        }

        // IP address not found in ranges file
        return false;
    }

    public static function getCountryName($ip)
    {
        $code=self::getCountryCode($ip);
        $CountryNames = [
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegowina",
            "BW" => "Botswana",
            "BR" => "Brazil",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CD" => "Congo, Democratic Republic",
            "CG" => "Congo, People’s Republic",
            "CR" => "Costa Rica",
            "CI" => "Cote d'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "TL" => "East Timor",
            "EC" => "Ecuador",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GR" => "Greece",
            "GD" => "Grenada",
            "GL" => "Greenland",
            "GT" => "Guatemala",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic Peoples Republic",
            "KR" => "Korea, Republic",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "MX" => "Mexico",
            "FM" => "Micronesia",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PL" => "Poland",
            "PT" => "Portugal",
            "QA" => "Qatar",
            "PR" => "Puerto Rico",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Príncipe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TW" => "Taiwan",
            "TH" => "Thailand",
            "TG" => "Togo",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UY" => "Uruguay",
        ];
      return $code&&isset($CountryNames[$code])?$CountryNames[$code]:false;
    }

}



