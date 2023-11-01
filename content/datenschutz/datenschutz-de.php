<?php
    $text_de = $DB->query_fetch("select text_de from datenschutz_text where id = 1");
    echo $text_de['text_de'];
    ?>
<!--
<div class="datenschutz pt-5">
	<div class="container pt-4 pb-5" id="hideScrollHorizontal">
		<h2 class="title__datenschutz pb-5 mb-4">ALLGEMEINE HINWEISE UND PFLICHTINFORMATIONEN</h2>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">DATENSCHUTZ</h3>
			<p class="datenschutz_text lead">Die Betreiber dieser Seiten nehmen den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln Ihre personenbezogenen Daten vertraulich und entsprechend der gesetzlichen Datenschutzvorschriften sowie dieser Datenschutzerklärung. Wenn Sie diese Website benutzen, werden verschiedene personenbezogene Daten erhoben. Personenbezogene Daten sind Daten, mit denen Sie persönlich identifiziert werden können. Die vorliegende Datenschutzerklärung erläutert, welche Daten wir erheben und wofür wir sie nutzen. Sie erläutert auch, wie und zu welchem Zweck das geschieht.</p>
			<p class="datenschutz_text">Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">HINWEIS ZUR VERANTWORTLICHEN STELLE</h3>
			<p class="datenschutz_text lead">Die verantwortliche Stelle für die Datenverarbeitung auf dieser Website ist:</p>
			<p class="datenschutz__address">Frowein GMBH & CO. KG<br/>Am Reislebach 83<br/>72461 Albstadt</p>
			<table class="table table-borderless kontakt__item-col w-auto">
				<tr>
					<td class="px-0">
						<p class="text-left mb-0 pe-2"><img src="/images/svg/contact/kicon2.svg" class="img-fluid"></p>
					</td>
					<td>
						<a class="k-telephone" href="tel:+49 7432 956-0">+49 7432 956-0</a>
					</td>
				</tr>
				<tr>
					<td class="px-0">
						<p class="text-left mb-0"><img src="/images/svg/contact/kicon4.svg" class="img-fluid"></p>
					</td>
					<td>
						<a class="k-email text-decoration-underline" href="mailto:info@frowein808.de">info@frowein808.de</a>
					</td>
				</tr>
			</table>
			<p class="datenschutz_text lead">Verantwortliche Stelle ist die natürliche oder juristische Person, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten (z.B. Namen, E-Mail-Adressen o. Ä.) entscheidet.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">WIDERRUF IHRER EINWILLIGUNG ZUR DATENVERARBEITUNG</h3>
			<p class="datenschutz_text">Viele Datenverarbeitungsvorgänge sind nur mit Ihrer ausdrücklichen Einwilligung möglich. Sie können eine bereits erteilte Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitung bleibt vom Widerruf unberührt.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">BESCHWERDERECHT BEI DER ZUSTÄNDIGEN STELLE</h3>
			<p class="datenschutz_text">Im Falle datenschutzrechtlicher Verstöße steht dem Betroffenen ein Beschwerderecht bei einer der Aufsichtsbehörden zu. Zuständige Aufsichtsbehörde in datenschutzrechtlichen Fragen ist der Landesdatenschutzbeauftragte des Bundeslandes Baden-Württemberg.<br/><a href="https://www.bfdi.bund.de/DE/Service/Anschriften/anschriften_table.html" target="_blank">https://www.bfdi.bund.de/DE/Infothek/Anschriften_Links/anschriften_links-node.html</a></p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">RECHT AUF DATENÜBERTRAGBARKEIT</h3>
			<p class="datenschutz_text">Sie haben das Recht, Daten, die wir auf Grundlage Ihrer Einwilligung oder in Erfüllung eines Vertrags automatisiert verarbeiten, an sich oder an einen Dritten in einem gängigen, maschinenlesbaren Format aushändigen zu lassen. Sofern Sie die direkte Übertragung der Daten an einen anderen Verantwortlichen verlangen, erfolgt dies nur, soweit es technisch machbar ist.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">SSL- BZW. TLS-VERSCHLÜSSELUNG</h3>
			<p class="datenschutz_text">Diese Seite nutzt aus Sicherheitsgründen und zum Schutz der Übertragung vertraulicher Inhalte, wie zum Beispiel Bestellungen oder Anfragen, die Sie an uns als Seitenbetreiber senden, eine SSL-bzw. TLS-Verschlüsselung. Eine verschlüsselte Verbindung erkennen Sie daran, dass die Adresszeile des Browsers von “http://” auf “https://” wechselt und an dem Schloss-Symbol in Ihrer Browserzeile. Wenn die SSL- bzw. TLS-Verschlüsselung aktiviert ist, können die Daten, die Sie an uns übermitteln, nicht von Dritten mitgelesen werden.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">AUSKUNFT, SPERRUNG, LÖSCHUNG</h3>
			<p class="datenschutz_text">Sie haben im Rahmen der geltenden gesetzlichen Bestimmungen jederzeit das Recht auf unentgeltliche Auskunft über Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der Datenverarbeitung und ggf. ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit an unsere in der Datenschutzerklärung angegebenen Adresse an uns wenden.</p>
		</div>
		<div class="pb-4">
			<h3 class="datenschutz_uppertitle">DATENSCHUTZBEAUFTRAGTER</h3>
			<p class="datenschutz_text lead">Wir haben für unser Unternehmen einen Datenschutzbeauftragten bestellt.</p>
			<p class="datenschutz__address">Frowein GMBH & CO. KG<br/>Am Reislebach 83<br/>72461 Albstadt</p>
			<table class="table table-borderless kontakt__item-col w-auto">
				<tr>
					<td class="px-0">
						<p class="text-left mb-0 pe-2"><img src="/images/svg/contact/kicon2.svg" class="img-fluid"></p>
					</td>
					<td>
						<a class="k-telephone" href="tel:+49 7432 956-0">+49 7432 956-0</a>
					</td>
				</tr>
				<tr>
					<td class="px-0">
						<p class="text-left mb-0"><img src="/images/svg/contact/kicon4.svg" class="img-fluid"></p>
					</td>
					<td>
						<a class="k-email text-decoration-underline" href="mailto:info@frowein808.de">info@frowein808.de</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">DATENERFASSUNG AUF UNSERER WEBSITE COOKIES</h3>
			<p class="datenschutz_text">Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden und die Ihr Browser speichert. Die meisten der von uns verwendeten Cookies sind so genannte “Session-Cookies”. Sie werden nach Ende Ihres Besuchs automatisch gelöscht. Andere Cookies bleiben auf Ihrem Endgerät gespeichert bis Sie diese löschen. Diese Cookies ermöglichen es uns, Ihren Browser beim nächsten Besuch wiederzuerkennen. Sie können Ihren Browser so einstellen, dass Sie über das Setzen von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der Cookies beim Schließen des Browser aktivieren. Bei der Deaktivierung von Cookies kann die Funktionalität dieser Website eingeschränkt sein. Cookies, die zur Durchführung des elektronischen Kommunikationsvorgangs oder zur Bereitstellung bestimmter, von Ihnen erwünschter Funktionen (z.B. Warenkorbfunktion) erforderlich sind, werden auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO gespeichert. Der Websitebetreiber hat ein berechtigtes Interesse an der Speicherung von Cookies zur technisch fehlerfreien und optimierten Bereitstellung seiner Dienste. Soweit andere Cookies (z.B. Cookies zur Analyse Ihres Surfverhaltens) gespeichert werden, werden diese in dieser Datenschutzerklärung gesondert behandelt.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">TECHNISCH NOTWENDIGE COOKIES</h3>
			<p class="datenschutz_text">Diese Cookies sind für die Bereitstellung von Diensten, die über unsere Website verfügbar sind, und für die Verwendung bestimmter Funktionen unserer Website von wesentlicher Bedeutung. Ohne diese Cookies können wir Ihnen bestimmte Dienste auf unserer Website nicht zur Verfügung stellen.</p>
			<div id="scrollTableMobile">
				<table class="table table-bordered datenschutz__table">
					<thead>
						<tr class="text-center">
							<th>Name</th>
							<th>Anbieter</th>
							<th>Zweck</th>
							<th>Ablauf</th>
							<th>Typ</th>
						</tr>
					</thead>
					<tbody>
						<tr class="align-middle">
							<td>language</td>
							<td>frowein808.de</td>
							<td class="w-40">Speichert bevorzugte Sprache des Benutzers auf der Website.</td>
							<td>29 Tage</td>
							<td>HTTP Cookie</td>
						</tr>
						<tr class="align-middle">
							<td>PHPSESSID</td>
							<td>frowein808.de</td>
							<td>Behält die Zustände des Benutzers bei allen Seitenanfragen bei.</td>
							<td>Session</td>
							<td>HTTP Cookie</td>
						</tr>
						<tr class="align-middle">
							<td>NID</td>
							<td>google.com</td>
							<td>Werden von Google gesetzt, sobald das Google+ Social Plugin durch den Benutzer auf unserer Website aktiviert wurde.</td>
							<td>6 Monaten</td>
							<td>HTTP Cookie</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">MARKETING UND RE-TARGETING COOKIES</h3>
			<p class="datenschutz_text">Solche Cookies werden im Normalfall von unseren Marketing- und Werbepartnern gesetzt. Mit diesen Cookies kann von Ihnen ein Interessenprofil erstellt werden, um Ihnen für Sie zugeschnittene Werbung anzuzeigen (Targeted Ads). Wenn Sie diese Cookies ablehnen, wird Ihnen die Werbung nicht basierend auf Ihren Interessen angezeigt.</p>
			<div id="scrollTableMobile">
				<table class="table table-bordered datenschutz__table">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Anbieter</th>
						<th>Zweck</th>
						<th>Ablauf</th>
						<th>Typ</th>
					</tr>
				</thead>
				<tbody>
					<tr class="align-middle">
						<td>GPS</td>
						<td>youtube.com</td>
						<td class="w-50">Registriert eine eindeutige ID auf mobilen Geräten, um Tracking basierend auf dem geografischen GPS-Standort zu ermöglichen.</td>
						<td>1 Tag</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>IDE</td>
						<td>doubleclick.net</td>
						<td class="w-50">Verwendet von Google DoubleClick, um die Handlungen des Benutzers auf der Webseite nach der Anzeige oder dem Klicken auf eine der Anzeigen des Anbieters zu registrieren und zu melden, mit dem Zweck der Messung der Wirksamkeit einer Werbung und der Anzeige zielgerichteter Werbung für den Benutzer.</td>
						<td>1 Jahr</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>PREF</td>
						<td>youtube.com</td>
						<td class="w-50">Registriert eine eindeutige ID, die von Google verwendet wird, um Statistiken dazu, wie der Besucher YouTube-Videos auf verschiedenen Websites nutzt, zu behalten.</td>
						<td>8 Monate</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>test_cookie</td>
						<td>youtube.com</td>
						<td class="w-50">Verwendet, um zu überprüfen, ob der Browser des Benutzers Cookies unterstützt.</td>
						<td>1 Tag</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>VISITOR_INFO1_LIVE</td>
						<td>youtube.com</td>
						<td class="w-50">Versucht, die Benutzerbandbreite auf Seiten mit integrierten YouTube-Videos zu schätzen.</td>
						<td>179 Tage</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>YSC</td>
						<td>youtube.com</td>
						<td class="w-50">Registriert eine eindeutige ID, um Statistiken der Videos von YouTube, die der Benutzer gesehen hat, zu behalten.</td>
						<td>Session</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-cast-installed</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Session</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-connected -devices</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Persistent</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-device-id</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Persistent</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-fast-check-period</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Session</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-session-app</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Session</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>yt-remote-session-name</td>
						<td>youtube.com</td>
						<td class="w-50">Speichert die Benutzereinstellungen beim Abruf eines auf anderen Webseiten integrierten Youtube-Videos.</td>
						<td>Session</td>
						<td>HTML Local Storage</td>
					</tr>
					<tr class="align-middle">
						<td>1P_JAR</td>
						<td>youtube.com</td>
						<td class="w-50">Dieses Cookie wird verwendet, um die Werbedienste von Google zu unterstützen.</td>
						<td>17 Tagen</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>SID, HSID, SSID, SIDSS</td>
						<td>youtube.com</td>
						<td class="w-50">Remarketing-Aktivität.</td>
						<td>Max. 2 Jahren</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>APISID, CONSENT, SAPISID</td>
						<td>youtube.com</td>
						<td class="w-50">Diese Cookies werden von Google gesetzt, um Ihnen dessen Dienste zur Verfügung zu stellen.</td>
						<td>Max. 2 Jahren</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>DV</td>
						<td>google.com</td>
						<td class="w-50">Dieses Cookie wird verwendet, um die Werbedienste von Google zu unterstützen.</td>
						<td>5 Minuten</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>SEARCH_SAMESITE</td>
						<td>google.com</td>
						<td class="w-50">Dieses Cookie wird verwendet, um zu verhindern, dass der Browser dieses Cookie zusammen mit standortübergreifenden Anforderungen sendet.</td>
						<td>Session</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>SIDCC</td>
						<td>google.com</td>
						<td class="w-50">Das Cookie beschützt die Daten des Benutzers vor unautorisiert Zugriffen.</td>
						<td>3 Monaten</td>
						<td>HTTP Cookie</td>
					</tr>
					<tr class="align-middle">
						<td>ANID</td>
						<td>google.com</td>
						<td class="w-50">Diese Cookies werden verwendet, um Informationen darüber zu sammeln, wie Besucher unsere Website nutzen. Wir verwenden die Informationen, um Berichte zu erstellen und die Website zu verbessern. Die Cookies sammeln Informationen in anonymisierter Form.</td>
						<td>6 Monaten</td>
						<td>HTTP Cookie</td>
					</tr>
				</tbody>
				</table>
			</div>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">TRACKING UND PERFORMANCE COOKIES</h3>
			<p class="datenschutz_text lead">Diese Cookies werden zum Sammeln von Informationen verwendet, um den Verkehr auf unserer Website und die Nutzung unserer Website durch Besucher zu analysieren.</p> 
			<p class="datenschutz_text lead">Diese Cookies können beispielsweise nachverfolgen, wie lange Sie auf der Website verweilen oder welche Seiten Sie besuchen. So können wir verstehen, wie wir unsere Website für Sie verbessern können.</p>
			<p class="datenschutz_text lead">Die durch diese Tracking- und Performance-Cookies gesammelten Informationen identifizieren keinen einzelnen Besucher.</p>
			<div id="scrollTableMobile">
				<table class="table table-bordered datenschutz__table">
					<thead>
						<tr class="text-center">
							<th>Name</th>
							<th>Anbieter</th>
							<th>Zweck</th>
							<th>Ablauf</th>
							<th>Typ</th>
						</tr>
					</thead>
					<tbody>
						<tr class="align-middle">
							<td>_ga</td>
							<td>google.com</td>
							<td class="w-50">Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.</td>
							<td>2 Jahre</td>
							<td>HTTP Cookie</td>
						</tr>
						<tr class="align-middle">
							<td>_gat</td>
							<td>google.com</td>
							<td class="w-50">Wird von Google Analytics verwendet, um die Anforderungsrate einzuschränken.</td>
							<td>1 Tag</td>
							<td>HTTP Cookie</td>
						</tr>
						<tr class="align-middle">
							<td>_gid</td>
							<td>google.com</td>
							<td class="w-50">Registriert eine eindeutige ID, die verwendet wird, um statistische Daten dazu, wie der Besucher die Website nutzt, zu generieren.</td>
							<td>1 Tag</td>
							<td>HTTP Cookie</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="pt-3">
				<a href="#" class="cookie-button">Cookie Einstellungen Verwalten</a>
			</div>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">SERVER-LOG-DATEIEN</h3>
			<p class="datenschutz_text lead">Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten Server-Log-Dateien, die Ihr Browser automatisch an uns übermittelt. Dies sind:</p>
			<p class="datenschutz_text lead">Browsertyp und Browserversion</p>
			<p class="datenschutz_text lead">verwendetes Betriebssystem</p>
			<p class="datenschutz_text lead">Referrer URL</p>
			<p class="datenschutz_text lead">Hostname des zugreifenden Rechners</p>
			<p class="datenschutz_text lead">Uhrzeit der Serveranfrage</p>
			<p class="datenschutz_text lead">IP-Adresse</p>
			<p class="datenschutz_text lead">Eine Zusammenführung dieser Daten mit anderen Datenquellen wird nicht vorgenommen. Grundlage für die Datenverarbeitung ist Art. 6 Abs. 1 lit. b DSGVO, der die Verarbeitung von Daten zur Erfüllung eines Vertrags oder vorvertraglicher Maßnahmen gestattet.</p> 
		</div>
		<div class="pb-5 mt-5">
			<h3 class="datenschutz_uppertitle">KONTAKTFORMULAR</h3>
			<p class="datenschutz_text lead">Wenn Sie uns per Kontaktformular Anfragen zukommen lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter. Die Verarbeitung der in das Kontaktformular eingegebenen Daten erfolgt somit ausschließlich auf Grundlage Ihrer Einwilligung (Art. 6 Abs. 1 lit. a DSGVO). Sie können diese Einwilligung jederzeit widerrufen. Dazu reicht eine formlose Mitteilung per E-Mail an uns. Die Rechtmäßigkeit der bis zum Widerruf erfolgten Datenverarbeitungsvorgänge bleibt vom Widerruf unberührt. Die von Ihnen im Kontaktformular eingegebenen Daten verbleiben bei uns, bis Sie uns zur Löschung auffordern, Ihre Einwilligung zur Speicherung widerrufen oder der Zweck für die Datenspeicherung entfällt (z.B. nach abgeschlossener Bearbeitung Ihrer Anfrage). Zwingende gesetzliche Bestimmungen – insbesondere Aufbewahrungsfristen – bleiben unberührt.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">ANALYSE TOOLS UND WERBUNG</h3>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">GOOGLE ANALYTICS</h3>
			<p class="datenschutz_text lead">Diese Website nutzt Funktionen des Webanalysedienstes Google Analytics. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA. Google Analytics verwendet so genannte "Cookies". Das sind Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert. Die Speicherung von Google-Analytics-Cookies erfolgt auf Grundlage von Art. 6 Abs. 1 lit. f DSGVO. Der Websitebetreiber hat ein berechtigtes Interesse an der Analyse des Nutzerverhaltens, um sowohl sein Webangebot als auch seine Werbung zu optimieren.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">IP ANONYMISIERUNG</h3>
			<p class="datenschutz_text lead">Wir haben auf dieser Website die Funktion IP-Anonymisierung aktiviert. Dadurch wird Ihre IP-Adresse von Google innerhalb von Mitgliedstaaten der Europäischen Union oder in anderen Vertragsstaaten des Abkommens über den Europäischen Wirtschaftsraum vor der Übermittlung in die USA gekürzt. Nur in Ausnahmefällen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivitäten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">BROWSER PLUG-IN</h3>
			<p class="datenschutz_text lead">Sie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht sämtliche Funktionen dieser Website vollumfänglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch den Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem Sie das unter dem folgenden Link verfügbare Browser-Plug-In herunterladen und installieren <a class="text-decoration-underline" href="https://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">https://tools.google.com/dlpage/gaoptout?hl=de</a>.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">WIDERSPRUCH GEGEN DATENERFASSUNG</h3>
			<p class="datenschutz_text lead">Sie können die Erfassung Ihrer Daten durch Google Analytics verhindern, indem Sie auf folgenden Link klicken. Es wird ein Opt-Out-Cookie gesetzt, der die Erfassung Ihrer Daten bei zukünftigen Besuchen dieser Website verhindert: Google Analytics deaktivieren.</p>
			<p class="datenschutz_text lead">Mehr Informationen zum Umgang mit Nutzerdaten bei Google Analytics finden Sie in der Datenschutzerklärung von Google: <a class="text-decoration-underline" href="https://support.google.com/analytics/answer/6004245?hl=de" target="_blank">https://support.google.com/analytics/answer/6004245?hl=de</a>.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">AUFTRAGSVERARBEITUNG</h3>
			<p class="datenschutz_text lead">Wir haben mit Google einen Vertrag zur Auftragsverarbeitung abgeschlossen und setzen die strengen Vorgaben der deutschen Datenschutzbehörden bei der Nutzung von Google Analytics vollständig um.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">PLUGINS UND TOOLS</h3>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">YOUTUBE</h3>
			<p class="datenschutz_text lead">Unsere Website nutzt Plugins der von Google betriebenen Seite YouTube. Betreiber der Seiten ist die YouTube, LLC, 901 Cherry Ave., San Bruno, CA 94066, USA. Wenn Sie eine unserer mit einem YouTube-Plugin ausgestatteten Seiten besuchen, wird eine Verbindung zu den Servern von YouTube hergestellt. Dabei wird dem YouTube- Server mitgeteilt, welche unserer Seiten Sie besucht haben. Wenn Sie in Ihrem YouTube-Account eingeloggt sind, ermöglichen Sie YouTube, Ihr Surfverhalten direkt Ihrem persönlichen Profil zuzuordnen. Dies können Sie verhindern, indem Sie sich aus Ihrem YouTube-Account ausloggen. Die Nutzung von YouTube erfolgt im Interesse einer ansprechenden Darstellung unserer Online-Angebote. Dies stellt ein berechtigtes Interesse im Sinne von Art. 6 Abs.1 lit. f DSGVO dar. Weitere Informationen zum Umgang mit Nutzerdaten finden Sie in der Datenschutzerklärung von YouTube unter: <a class="text-decoration-underline" href="https://www.google.de/intl/de/policies/privacy" target="_blank">https://www.google.de/intl/de/policies/privacy</a>.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">NEWSLETTERVERSAND</h3>
			<p class="datenschutz_text lead">Werbenewsletter<br/>Auf unserer Internetseite wird Ihnen die Möglichkeit eingeräumt, den Newsletter unseres Unternehmens zu abonnieren. Welche personenbezogenen Daten bei der Bestellung des Newsletters an uns übermittelt werden, ergibt sich aus der hierzu verwendeten Eingabemaske. Wir informieren unsere Kunden und Geschäftspartner in regelmäßigen Abständen im Wege eines Newsletters über unsere Angebote. Der Newsletter unseres Unternehmens kann von Ihnen grundsätzlich nur dann empfangen werden, wenn<br/>1. Sie über eine gültige E-Mail-Adresse verfügen und<br/>2. Sie sich für den Newsletterversand registriert haben.</p>
			<p class="datenschutz_text lead">An die von Ihnen erstmalig für den Newsletterversand eingetragene E-Mail-Adresse wird aus rechtlichen Gründen eine Bestätigungsmail im Double-Opt-In-Verfahren versendet. Diese Bestätigungsmail dient der Überprüfung, ob Sie als Inhaber der E-Mail-Adresse den Empfang des Newsletters autorisiert haben.</p>
			<p class="datenschutz_text lead">Bei der Anmeldung zum Newsletter speichern wir ferner die von Ihrem Internet-Service-Provider (ISP) vergebene IP-Adresse des von Ihnen zum Zeitpunkt der Anmeldung verwendeten IT-Systems sowie das Datum und die Uhrzeit der Anmeldung. Die Erhebung dieser Daten ist erforderlich, um den (möglichen) Missbrauch Ihrer E-Mail-Adresse zu einem späteren Zeitpunkt nachvollziehen zu können und dient deshalb unserer rechtlichen Absicherung.</p>
			<p class="datenschutz_text lead">Die im Rahmen einer Anmeldung zum Newsletter erhobenen personenbezogenen Daten werden ausschließlich zum Versand unseres Newsletters verwendet. Ferner könnten Abonnenten des Newsletters per E-Mail informiert werden, sofern dies für den Betrieb des Newsletter-Dienstes oder eine diesbezügliche Registrierung erforderlich ist, wie dies im Falle von Änderungen am Newsletterangebot oder bei der Veränderung der technischen Gegebenheiten der Fall sein könnte. Es erfolgt keine Weitergabe der im Rahmen des Newsletter-Dienstes erhobenen personenbezogenen Daten an Dritte. Das Abonnement unseres Newsletters kann durch Sie jederzeit gekündigt werden. Die Einwilligung in die Speicherung personenbezogener Daten, die Sie uns für den Newsletterversand erteilt haben, kann jederzeit widerrufen werden. Zum Zwecke des Widerrufs der Einwilligung findet sich in jedem Newsletter ein entsprechender Link. Alternativ können Sie uns auch eine E-Mai an info@frowein808.de mit der Betreffzeile „Newsletter Abmeldung“ senden.</p>
			<p class="datenschutz_text lead">Rechtsgrundlage der Datenverarbeitung zum Zwecke des Newsletterversands ist Art. 6 Abs. 1 lit. a DSGVO.</p>
		</div>
		<div class="pb-5">
			<h3 class="datenschutz_uppertitle">WIDERSPRUCH GEGEN WERBE-MAILS</h3>
			<p class="datenschutz_text lead">Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-E-Mails, vor.</p>
		</div>
		<div class="text-center">
			<img class="daten_telenorma_logo" src="/images/datenschutz/Poweredby.svg">
		</div>
	</div>
</div>
-->