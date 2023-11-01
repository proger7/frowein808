<?php


    $segment = "https://www.frowein808.de".$_SERVER['REQUEST_URI'];
    $pos      = strripos($segment, "www.frowein808.de/products/");
    $pos1      = strripos($segment, "www.frowein808.de/product/");
    $pos2      = strripos($segment, "www.frowein808.de/news/");
    $pos3      = strripos($segment, "www.frowein808.de/news/archiv/?archive");
    $pos4      = strripos($segment, "www.frowein808.de/contact/germany/");
    $pos5      = strripos($segment, "www.frowein808.de/contact/europe/");
    $pos6      = strripos($segment, "www.frowein808.de/contact/international/");
    $pos7      = strripos($segment, "www.frowein808.de/product-info/downloads/frowein808");



    /* Categories */
    $cat1_en  = strripos($segment, "www.frowein808.de/en/products/INSEKTENBEK%C3%84MPFUNG");
    $cat1_de  = strripos($segment, "www.frowein808.de/de/products/INSECT+CONTROL");

    $cat2_en  = strripos($segment, "www.frowein808.de/en/products/APPLIKATIONSGER%C3%84TE");
    $cat2_de  = strripos($segment, "www.frowein808.de/de/products/APPLICATION+EQUIPMENT");


    $cat3_en  = strripos($segment, "www.frowein808.de/en/products/BETTWANZENBEK%C3%84MPFUNG");
    $cat3_de  = strripos($segment, "www.frowein808.de/de/products/BED+BUG+CONTROL");


    $cat4_en  = strripos($segment, "www.frowein808.de/en/products/TAUBENABWEHR");
    $cat4_de  = strripos($segment, "www.frowein808.de/de/products/PIGEON+REPELLENT");

    $cat5_en  = strripos($segment, "www.frowein808.de/en/products/DESINFEKTIONS-+%26+PFLEGEMITTEL");
    $cat5_de  = strripos($segment, "www.frowein808.de/de/products/Products+for+disinfection+and+care");


    $cat6_en  = strripos($segment, "www.frowein808.de/en/products/SCHADNAGERBEK%C3%84MPFUNG");
    $cat6_de  = strripos($segment, "www.frowein808.de/de/products/RODENT+CONTROL");


    $cat7_en  = strripos($segment, "www.frowein808.de/en/products/SPEZIALPRODUKTE");
    $cat7_de  = strripos($segment, "www.frowein808.de/de/products/SPECIAL+PRODUCTS");




    if ($pos === false ) {
    } else {
        $new_url = str_replace("www.frowein808.de/products/", "www.frowein808.de/de/products/", $segment);
        header("location:".$new_url, true, 301);
    }
    if ($pos1 === false ) {
    } else {
        $new_url = str_replace("www.frowein808.de/product/", "www.frowein808.de/de/products/", $segment);
        header("location:".$new_url, true, 301);
    }
    if ($pos2 === false ) {
    } else {
        $new_url = str_replace("www.frowein808.de/news/", "www.frowein808.de/de/news/", $segment);
        header("location:".$new_url, true, 301);
    }
    if ($pos3 === false ) {
    } else {
        header("location:https://www.frowein808.de", true, 301);
    }
    if ($pos4 === false ) {
    } else {
        header("location:https://www.frowein808.de/de/contact/germany/", true, 301);
    }
    if ($pos5=== false ) {
    } else {
        header("location:https://www.frowein808.de/de/contact/europe/", true, 301);
    }
    if ($pos6 === false ) {
    } else {
        header("location:https://www.frowein808.de/de/contact/international/", true, 301);
    }

    if ($pos7 === false ) {
    } else {
        header("location:https://www.frowein808.de/de/partner/downloads/", true, 301);
    }


    /* Categories */
    if ($cat1_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/INSECT+CONTROL", true, 301);
    }
    if ($cat1_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/INSEKTENBEK%C3%84MPFUNG", true, 301);
    }


    if ($cat2_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/APPLICATION+EQUIPMENT", true, 301);
    }
    if ($cat2_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/APPLIKATIONSGER%C3%84TE", true, 301);
    }


    if ($cat3_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/BED+BUG+CONTROL", true, 301);
    }
    if ($cat3_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/BETTWANZENBEK%C3%84MPFUNG", true, 301);
    }


    if ($cat4_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/PIGEON+REPELLENT", true, 301);
    }
    if ($cat4_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/TAUBENABWEHR", true, 301);
    }


    if ($cat5_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/Products+for+disinfection+and+care", true, 301);
    }
    if ($cat5_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/DESINFEKTIONS-+%26+PFLEGEMITTEL", true, 301);
    }


    if ($cat6_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/RODENT+CONTROL", true, 301);
    }
    if ($cat6_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/SCHADNAGERBEK%C3%84MPFUNG", true, 301);
    }


    if ($cat7_en === false ) {
    } else {
        header("location:https://www.frowein808.de/en/products/SPECIAL+PRODUCTS", true, 301);
    }
    if ($cat7_de === false ) {
    } else {
        header("location:https://www.frowein808.de/de/products/SPEZIALPRODUKTE", true, 301);
    }