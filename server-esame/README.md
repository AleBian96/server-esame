# server-esame

Il server è composto da 3 file .java:
	-server.java (classe principale).
	-messageHandler.java (interprete per richieste HTTP da parte dei clients).
	-PHPInterpreter.java (classe wrapper per tradurre il PHP).

funzionamento:

Server:
	avvio:
		-Il server contatta DuckDNS per aggiornare il DDNS.
		-Il server avvia il processo principale ed aspetta le connessioni.
	
	connessione:
		-Viene creato un nuovo thread che riceve la richiesta del client e la passa a messageHandler che semplifica la richiesta.
		-Il server esegue la richiesta inviando il file richiesto.

messageHandler:
	-Viene ricevuta la richiesta e divisa il tante stringhe per semplificare l'uso della richiesta.

PHPInterpreter:
	avvio:
		-Viene controllato che il file "wrap.php" esiste, nel caso contrario verrà creato.

	richiesta di traduzione:
		-Viene passato il percorso del file da tradurre e gli array "POST" "GET" e "COOKIE".
		-Effettuata la traduzione ritorna il file che poi andrà spedito al client.
	
	nota:
		-PHPInterpreter usa php-cli installato nella macchina che fa da server, può essere adattato per utilizzare la versione portable.

wrap.php
	Include tutte le librerie presenti nella cartella LIBRARIES.
	Carica gli array "POST" "GET" e "COOKIE" con i parametri che gli vengono passati.
	Ritorna il risultato della traduzione del file richiesto.

LIBRARIES/sessionHandler.php
	Permette la creazione e l'uso delle sessioni.
	Usa il database presente in DATABASES/SESSION.db.
