<?php
    /*
echo $_SERVER['REQUEST_URI'];
if ($_SERVER['REQUEST_URI'] == "/contact/germany/" ){
    header("location:https://www.frowein808.de/de/contact/germany/", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/contact/europe/" ){
    header("location:https://www.frowein808.de/de/contact/europe/", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/contact/international/" ){
    header("location:https://www.frowein808.de/de/contact/international/", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEKÄMPFUNG/");
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/Contrax_All_in_Mice_und_All_in_Rats" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/Contrax_All_in_Mice_und_All_in_Rats", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/contrax-box_808_" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-box_808_" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEKÄMPFUNG/contrax-box_808_", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-box_808_sf" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-box_808_sf" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-box_808_sf", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/contrax-d_block_40" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-d_block_40" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-d_block_40", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/contrax-d_koeder" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-d_koeder" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-d_koeder", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/contrax-top_bloc" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-top_bloc" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/contrax-top_bloc", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/down-under_erdanker" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/down-under_erdanker" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/down-under_erdanker", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-box_profi" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-box_profi" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-box_profi", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-d_block" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_block" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-d_block/" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_block/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_block", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-d_pad" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-d_pad/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_pad" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_pad/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-d_pad", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-duo" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-duo/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-depot_profi" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-depot_profi/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-depot_profi" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-depot_profi/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-depot_profi", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-duo_bf" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-duo_bf/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo_bf" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo_bf/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-duo_bf", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-monitor_block" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-monitor_block/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_block" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_block/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_block", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-monitor_sachet" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/mausex-monitor_sachet/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_sachet" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_sachet/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/mausex-monitor_sachet", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/maeusetunnel" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/maeusetunnel/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/maeusetunnel" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/maeusetunnel/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/maeusetunnel", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/pmomagnete" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEKÄMPFUNG/pmomagnete/" ||$_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/pmomagnete" || $_SERVER['REQUEST_URI'] == "/products/SCHADNAGERBEK%C3%84MPFUNG/pmomagnete/" ){
    header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG/pmomagnete", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bettwanzenfalle_domobios" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bettwanzenfalle_domobios/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenfalle_domobios" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenfalle_domobios/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenfalle_domobios", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bbcheck" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bbcheck/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bbcheck" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bbcheck/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/bbcheck", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bbcheckset" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bbcheckset/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bbcheckset" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bbcheckset/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/bbcheckset", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bettwanzenmonitor" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/bettwanzenmonitor/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenmonitor" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenmonitor/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/bettwanzenmonitor", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/detmol-cap-9" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/detmol-cap-9/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/detmol-cap-9" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/detmol-cap-9/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/detmol-cap-9", true, 301);
}
if ($_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/gerinol-ec-9" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEKÄMPFUNG/gerinol-ec-9/" ||$_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/gerinol-ec-9" || $_SERVER['REQUEST_URI'] == "/products/BETTWANZENBEK%C3%84MPFUNG/gerinol-ec-9/" ){
    header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG/gerinol-ec-9", true, 301);
}
*/

