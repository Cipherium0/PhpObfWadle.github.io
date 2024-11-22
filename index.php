<?php

try {
    error_reporting(0);
ini_set('display_errors', 0); 

ob_start();
session_start();
@ini_set('default_charset', 'utf-8');
date_default_timezone_set('UTC');
define('version', '0.1');

if (isset($_GET['thanks'])) {
    $setThanks = '<div class="alert alert-success"><i class="fa fa-beer"></i><strong>Teşekkürler!</strong> Bu projeye destek verdiğiniz için teşekkür ederim, her şeyin en iyisi sizinle olsun :) </div>';
} else { 
    $setThanks = ''; 
}

    echo '
<html lang="tr">
<<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Kod Obfuscator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css">
    <link href="assets/style.css" rel="stylesheet">
    <script src="animasyon.js"></script>
</head>
<body>
    <div id="cont_wrap">
        <div class="top-info">
            <p><b>PHP Kod Obfuscator</b></p>
            Merhaba ve Hoşgeldiniz! <small>Bu, PHP dosyaları için özel olarak kodlanmış, PHP obfuscatorıdır. Kodlar, PHP etiketlerini kullanmak yerine echo ve print kullanır.</small><br><br>
            Obfuscation (gizleme) amacımız, kodları orijinal kaynaktan farklı hale getirmek ve başkalarının kodları düzenlemesini engellemektir, özellikle de kodlama bilmeyenler için.
        </div>
  <body>
</head>
        <div class="content">
            '.$setThanks.'
            
            <form action="" method="post" id="obfuscation_form">
                <input name="obf_start" type="hidden"/>
                
                <div class="group">
                    <label for="obf_code_single"><h3>Tekli PHP Kod Obfuscation</h3></label>
                    <textarea name="obf_code_single" placeholder="PHP Kaynak Kodu Girin" id="editing" spellcheck="false">'.$sourceCode.'</textarea>
                </div>

                <div class="group">
                    <label for="settings"><h3>Obfuscation Ayarları</h3></label>
                    
                    <div>
                        <b>Fonksiyon Adlarını Yeniden Adlandır</b>:
                        <input type="checkbox" name="rn_fnc_name" checked />
                        Min Uzunluk: <input name="rn_fnc_name_len_min" value="32" />
                        Max Uzunluk: <input name="rn_fnc_name_len_max" value="64" />
                    </div>

                    <div>
                        <b>Değişken Adlarını Yeniden Adlandır</b>:
                        <input type="checkbox" name="rn_var_name" checked />
                        Min Uzunluk: <input name="rn_var_name_len_min" value="32" />
                        Max Uzunluk: <input name="rn_var_name_len_max" value="64" />
                    </div>

                    <div>
                        <b>Kod Boşluk/Tabağı Kaldır ve Değiştir</b>:
                        <input type="checkbox" name="use_space_tab_rem" checked />
                    </div>

                    <div>
                        <b>HTML Encode/Decode Etiketleri</b>:
                        <input type="checkbox" name="use_html_ende_tags" checked />
                        Rastgele HTML Yorumları Ekle: <input type="checkbox" name="use_html_ende_comments" checked />
                    </div>

                    <div>
                        <b>Encode/Decode Kod</b>:
                        <input type="checkbox" name="use_encode_w_eval" checked />
                        Tür:
                        <select name="use_encode_w_eval_type">
                            <option value="1">str_rot13(base64_encode(base64_encode(gzdeflate(</option>
                            <option value="2">str_rot13(strrev(base64_encode(gzdeflate(</option>
                            <option value="3">base64_encode(str_rot13(gzdeflate(str_rot13(</option>
                            <option value="4" selected>base64_encode(gzdeflate(</option>
                        </select>
                    </div>

                    <div>
                        <b>PHP Dosyalarına veya Koda Başlık Ekleyin</b>:
                        <textarea name="header_top" placeholder="Başlık ekleyin" spellcheck="false"></textarea>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" class="button" onclick="document.getElementById(\'obfuscation_form\').submit();"><i class="fa fa-compress"></i> Obfuscation Sürecini Başlat</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>';


	function generateName($len){
		$characters = '______0123456789_____ABCDEFG__HIJKLMNO_______0123456789_____PQRSTUVW__XYZ';
	
		$charactersLength = strlen($characters);
		$randomString = '_';
		for($i = 0; $i < $len; $i++){
			
			$randomString .= $characters[rand(0,$charactersLength - 1)];
			
		};

		return $randomString;

	};
	function generateRandSpaces($len){
		$randspaces = '';

		for($i = 0; $i < $len; $i++){
			
			$randspaces .= ' ';
			
		};

		return $randspaces;

	};
	if(isset($_POST['obf_start'])){
		$scrollBottom = 1;
		define("MySessionID",rand(100,9999999));
		$error = 0;
		$is_OBF_Single = ($_POST['obf_code_single'] === '') ? 0:1;
		$is_OBF_Zip = 0;
		if($is_OBF_Single == 1){
			$obf_path_unpacked = 'files/';
			$obf_path_packed = 'files/';
			file_put_contents($obf_path_unpacked."obf_single_".MySessionID.".txt",$_POST['obf_code_single']); chmod($obf_path_unpacked."obf_single_".MySessionID.".txt", 0755);
			$for_array_file_loop = array('obf_single_'.MySessionID.'.txt');

		} elseif($is_OBF_Zip == 1){
			$obf_path_unpacked = 'files/unpacked/';
			$obf_path_packed = 'files/packed/';
			$to_upload_file_path = $obf_path_unpacked.''.MySessionID.'/'.basename($_FILES["UploadedZipFile"]["name"]);
			if($_FILES["UploadedZipFile"]["size"] >= 33554432){
				$error = 100; goto End;

			};
			$for_array_file_loop = array();
			$zip_file = new ZipArchive;
			$result = $zip_file->open($_FILES["UploadedZipFile"]["tmp_name"]);
			if($result === TRUE){
				$php_cnt = 0; for( $in = 0; $in < $zip_file->numFiles; $in++){

						$file_info = $zip_file->statIndex($in);
						$file_type = pathinfo($file_info['name'],PATHINFO_EXTENSION);

						if($file_type === 'php'){
							
							$for_array_file_loop[] = ''.MySessionID.'/'.$file_info['name'];
							$php_cnt ++;
						};
				};

				if($php_cnt === 0){
					$error = 101; goto End;

				} else {
					$zip_file->extractTo($obf_path_unpacked.''.MySessionID.'/');

				};

			} else {
				$error = 102; goto End;

			};

		} else {
			$error = 103; goto End;

		};
		$htmlTagList = array("a","abbr","acronym","address","applet","area","article","aside","audio","b","base","basefont","bdi","bdo","bgsound","big","blink","blockquote","body","br","button","canvas","caption","center","cite","code","col","colgroup","content","data","datalist","dd","decorator","del","details","dfn","dir","div","dl","dt","element","em","embed","fieldset","figcaption","figure","font","footer","form","frame","frameset","h1","h2","h3","h4","h5","h6","head","header","hgroup","hr","html","i","iframe","img","input","ins","isindex","kbd","keygen","label","legend","li","link","listing","main","map","mark","marquee","menu","menuitem","meta","meter","nav","nobr","noframes","noscript","object","ol","optgroup","option","output","p","param","plaintext","pre","progress","q","rp","rt","ruby","s","samp","script","section","select","shadow","small","source","spacer","span","strike","strong","style","sub","summary","sup","table","tbody","td","template","textarea","tfoot","th","thead","time","title","tr","track","tt","u","ul","var","video","wbr","xmp");
		$i = 0; $numech = 0; $numechP = 0;
		$sesListOfFunctions = Array();
		foreach($for_array_file_loop as $array_file){

			# Load File
			$getFileToClean = file_get_contents($obf_path_unpacked.''.$array_file);

			preg_match_all('/(?<=function ).*?\b\w+\s*\(/', $getFileToClean, $sesFuncArrays); 

			foreach($sesFuncArrays[0] as $sesArrSet){

				if($sesArrSet == '__construct(') { continue; };	

				$sesArrSet = str_replace('(','',$sesArrSet);
				$sesListOfFunctions[''.$sesArrSet.''] = $sesArrSet;

			};

		};
		foreach($for_array_file_loop as $array_file){
			$getFileToClean = file_get_contents($obf_path_unpacked.''.$array_file);
			$getFileToClean = $getFileToClean.''.PHP_EOL;
			$getFileToClean = str_replace('https://', 'https:@@', $getFileToClean);
			$getFileToClean = str_replace('http://', 'http:@@', $getFileToClean);
			$getFileToClean = preg_replace('![ \n\r\t]+#.*[ \t]*[\r\n]!', "\n", $getFileToClean);  
			$getFileToClean = preg_replace('!\/\*.*?\*\/!s', "\n", $getFileToClean); 
			$getFileToClean = preg_replace('![ \n\r\t]\/\/.*[ \t]*[\r\n]!', "\n", $getFileToClean); 
			$getFileToClean = preg_replace('~\<\!\-\-(.*?)\-\-\>~s', "\n", $getFileToClean);
			$getFileToClean = preg_replace('~//<!\[CDATA\[\s*|\s*//\]\]>~', "\n", $getFileToClean); 
			$getFileToClean = preg_replace('/\n\s*\n/', "\n", $getFileToClean);

			$getFileToClean = str_replace('<?php','', $getFileToClean);
			$getFileToClean = str_replace('<?','', $getFileToClean);
			$getFileToClean = str_replace('?>','', $getFileToClean);
			file_put_contents($obf_path_unpacked.''.$array_file,$getFileToClean); chmod($obf_path_unpacked.''.$array_file, 0755);
			$php_code[$i] = fopen($obf_path_unpacked.''.$array_file, "r");

			while(($line_code = fgets($php_code[$i])) !== false){
				preg_match_all('/\$([a-zA-Z\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', $line_code, $sesVarArrays);
				$setVarArrCase = Array();
				foreach($sesVarArrays[0] as $sesArrFix){
					
					if($sesArrFix == '$this') { continue; };

					$setVarArrCase[''.$sesArrFix.''] = $sesArrFix;

				};
				if(count($setVarArrCase) >= 1 && $_POST['rn_var_name'] == true){

					if($_POST['rn_var_name_len_min'] > 200 ) { $setMin = 1; } else {
						if($_POST['rn_var_name_len_min'] > $_POST['rn_var_name_len_max'] ) { $setMin = 1; } else { $setMin = $_POST['rn_var_name_len_min']; };
					};
					if($_POST['rn_var_name_len_max'] > 200 ) { $setMax = 200; } else { $setMax = $_POST['rn_var_name_len_max']; };
					
					$keys = array_map('strlen', array_keys($setVarArrCase));
					array_multisort($keys, SORT_DESC, $setVarArrCase);

					$cntVar = 1;
					foreach($setVarArrCase as $sesVarArrays){

						if($varArrayGlb['var_saved'][''.$sesVarArrays.''] != ""){
							
							$line_code = str_replace($sesVarArrays,$varArrayGlb['var_saved'][''.$sesVarArrays.''],$line_code);

						} else {

							$NewNamelen = rand($setMin,$setMax) + $cntVar;

							$varArrayGlb['var_saved'][''.$sesVarArrays.''] = '$'.generateName($NewNamelen);

							$line_code = str_replace(''.$sesVarArrays.'',$varArrayGlb['var_saved'][''.$sesVarArrays.''],$line_code);

						};

						$cntVar ++;

					};

				};
				if(count($sesListOfFunctions) >= 1 && $_POST['rn_fnc_name'] == true){
					if($_POST['rn_fnc_name_len_min'] > 200 ) { $setMin = 1; } else {
						if($_POST['rn_fnc_name_len_min'] > $_POST['rn_fnc_name_len_max'] ) { $setMin = 1; } else { $setMin = $_POST['rn_fnc_name_len_min']; };
					};
					if($_POST['rn_fnc_name_len_max'] > 200 ) { $setMax = 200; } else { $setMax = $_POST['rn_fnc_name_len_max']; };
					$keys = array_map('strlen', array_keys($sesListOfFunctions));
					array_multisort($keys, SORT_DESC, $sesListOfFunctions);

					$cntFn = 1;
					foreach($sesListOfFunctions as $sesFuncArrays){
						
						if($varArrayGlb['func_saved'][''.$sesFuncArrays.''] != ""){
							
							$line_code = str_replace($sesFuncArrays,$varArrayGlb['func_saved'][''.$sesFuncArrays.''],$line_code);

						} else {

							$NewNamelen = rand($setMin,$setMax) + $cntFn;

							$varArrayGlb['func_saved'][''.$sesFuncArrays.''] = ''.generateName($NewNamelen);

							$line_code = str_replace(''.$sesFuncArrays.'',$varArrayGlb['func_saved'][''.$sesFuncArrays.''],$line_code);

						};

						$cntFn ++;

					};

				};
				$line_code = str_replace('https:@@', 'https://', $line_code);
				$line_code = str_replace('http:@@', 'http://', $line_code);
				if($line_code === ""){

					$setLineCode[$i][] = "";

				} else {

					$setLineCode[$i][] = $line_code;

				};


			};

			fclose($php_code[$i]);
			

			$php_code_combined = implode('',$setLineCode[$i]);

			if($_POST['use_html_ende_tags'] == true){
				foreach($htmlTagList as $htmlTagl){
					
					if($_POST['use_html_ende_comments'] == true){

						$htmlEntitlTagsRand = '<!-- '.generateRandSpaces(rand(5,20)).'Entitled '.generateName(rand(5,20)).'HTML '.generateRandSpaces(rand(5,20)).'Tag'.generateName(rand(5,20)).' -->';

					} else {

						$htmlEntitlTagsRand = '';

					};

					$php_code_combined = str_replace('<'.$htmlTagl.' ',htmlentities(htmlentities(''.$htmlEntitlTagsRand.'<'.$htmlTagl.'')).' ',$php_code_combined); # Ex: <a ...
					$php_code_combined = str_replace('<'.$htmlTagl.'>',htmlentities(htmlentities(''.$htmlEntitlTagsRand.'<'.$htmlTagl.'>')),$php_code_combined); # Ex: <head>
					$php_code_combined = str_replace('</'.$htmlTagl.'>',htmlentities(htmlentities('</'.$htmlTagl.'>'.$htmlEntitlTagsRand.'')),$php_code_combined); # Ex: </a>
					
				};
			};
			preg_match_all("/echo ?[\'\"](.*?)[\'\"];/ms", $php_code_combined, $echMatchCase);
			foreach($echMatchCase[0] as $match){
				$MadeRandNameFordecode = generateName(15);
				$php_code_combined = str_replace($match,'$'.generateName(38).' = "<header><div>.<b>.</div></header>"; $'.$MadeRandNameFordecode.' = html_entity_decode(html_entity_decode(\''.$echMatchCase[1][$numech].'\')); $'.generateName(38).' = "<header><div>.<b>.</div></header>"; echo $'.$MadeRandNameFordecode.'; $'.generateName(38).' = "<header><div>.<b>.</div></header>";',$php_code_combined);
				$numech ++;

			}
			preg_match_all("/print ?[\'\"](.*?)[\'\"];/ms", $php_code_combined, $echMatchCase);
			foreach($echMatchCase[0] as $match){
				$MadeRandNameFordecode = generateName(25);
				$php_code_combined = str_replace($match,'$'.generateName(38).' = "<header><div>.<b>.</div></header>"; $'.$MadeRandNameFordecode.' = html_entity_decode(html_entity_decode(\''.$echMatchCase[1][$numechP].'\')); $'.generateName(38).' = "<header><div>.<b>.</div></header>"; print $'.$MadeRandNameFordecode.'; $'.generateName(38).' = "<header><div>.<b>.</div></header>";',$php_code_combined);
				$numechP ++;

			}

			# Lastly Removing New Lines
			if($_POST['use_space_tab_rem'] == true){
				$php_code_combined = str_replace("	",' ', $php_code_combined);
				$php_code_combined = str_replace("  ",' ', $php_code_combined);
			};
			$php_code_combined = str_replace("\r",' ', $php_code_combined);
			$php_code_combined = str_replace("\n",' ', $php_code_combined);
			$php_code_combined = $php_code_combined;
			$php_result_code = '';

			if($_POST['header_top'] !== ""){

				$php_result_code .= '<?php'.PHP_EOL;
				$php_result_code .= '/*'.PHP_EOL;
				$php_result_code .= $_POST['header_top'].''.PHP_EOL;
				$php_result_code .= '*/'.PHP_EOL;
				$php_result_code .= '?>'.PHP_EOL;

			};
			
			if($_POST['use_encode_w_eval'] == false){

				$php_result_code .= $php_code_combined;

			} else {

				if($_POST['use_encode_w_eval_type'] === '1'){

					$php_result_code .= '<?php eval(gzinflate(base64_decode(base64_decode(str_rot13("'.str_rot13(base64_encode(base64_encode(gzdeflate($php_code_combined)))).'"))))); ?>';

				} elseif($_POST['use_encode_w_eval_type'] === '2'){

					$php_result_code .= '<?php eval(gzinflate(base64_decode(strrev(str_rot13("'.str_rot13(strrev(base64_encode(gzdeflate($php_code_combined)))).'"))))); ?>';

				} elseif($_POST['use_encode_w_eval_type'] === '3'){

					$php_result_code .= '<?php eval(str_rot13(gzinflate(str_rot13(base64_decode("'.base64_encode(str_rot13(gzdeflate(str_rot13($php_code_combined)))).'"))))); ?>';

				} elseif($_POST['use_encode_w_eval_type'] === '4'){

					$php_result_code .= '<?php eval(gzinflate(base64_decode("'.base64_encode(gzdeflate($php_code_combined)).'"))); ?>';

				} else {

					$php_result_code .= $php_code_combined;

				};

			};
			file_put_contents($obf_path_packed.''.$array_file,$php_result_code); chmod($obf_path_packed.''.$array_file, 0755);

			$i ++;
		};
		if($is_OBF_Single == 1){

			$Single_File_Content = file_get_contents($obf_path_packed.''.$array_file);

			echo'
				<label for="pwd"><h3 style="color:#38ad38;">Obfuscated Code Result</h3></label>
				<textarea id="resutOut" spellcheck="false">'.$Single_File_Content.'</textarea>
			';
			unlink($obf_path_packed.''.$array_file);

		} elseif($is_OBF_Zip == 1){

			echo $Succ_S.' Files Has Been Obfuscated & Zipped'.$Succ_E;
		};

		if($error !== 0){

			End:

			if($error == 100){ echo $Err_S.' File Size Is To Big And Is Not Allowed To Upload'.$Err_E; }
			elseif($error == 102){ echo $Err_S.' Opened Zip Was Not Valid And Failed To Extract'.$Err_E; }
			elseif($error == 103){ echo $Err_S.' Both TextArea And Upload Are Empty'.$Err_E; }
			else { echo $Err_S.' Something went wrong, Check your files & try again!'.$Err_E; };

		};
		
		unset($varArrayGlb);
		unset($varArrayGlb);
		unset($setVarArrCase);
		unset($sesFuncArray);
		
	};
	echo'</div>

<div>
    <div style="height:50px;"></div>
    <center>
        <div class="footer-content">
            <p style="font-size: 14px; color: #888;">&copy; 2023 <b>Waddleobf.vercell.app</b>, All Rights Reserved</p>
            <p style="font-size: 12px; color: #bbb; margin-top: 10px;">All visual aspects of this website have been coded by Waddleobf.vercell.app except for font-awesome icons.</p>
        </div>
    </center>
    <div style="height:50px;"></div>
</div>
<script>
    $(document).ready(function() {
        $("input#file-upload").change(function() {
            var ele = document.getElementById($("input#file-upload").attr("id"));
            var result = ele.files;
            $("#file_name_output").html(result[0].name);
        });

        if('.$scrollBottom.' == 1){
            $("html,body").animate({scrollTop: document.body.scrollHeight},"slow");
        };
    });
</script>
</body>
</html>

<style>
    /* Footer Styling */
    .footer-content {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .footer-content p {
        font-family: , sans-serif;
        line-height: 1.5;
        color: #888;
        margin: 0;
    }

    .footer-content b {
        color: #00bcd4;
    }

    .footer-content a {
        color: #00bcd4;
        text-decoration: none;
    }

    .footer-content a:hover {
        text-decoration: underline;
    }

    footer {
        background-color: #333;
        color: white;
        padding: 30px 0;
        font-size: 14px;
        text-align: center;
    }

    footer p {
        margin: 5px 0;
    }

    footer b {
        color: #00bcd4;
    }

    footer .small-text {
        font-size: 12px;
        color: #bbb;
        margin-top: 15px;
    
';
		
} catch (Exception $err) {
	echo $err->getMessage();
};

?>
