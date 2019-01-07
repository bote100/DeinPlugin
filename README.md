# DeinPlugin
Hier ist der **unfertige** Sourcecode von meiner Implementation des DeinPlugin Shops für Pascal, da dieser den Shop nicht mehr abnimmt, stelle ich den aktuellen Fortschritt allen zur Verfügung, die sich den Code mal anschauen wollen.

# Disclaimer
Ich bin kein professioneller Webentwickler und arbeite im Normalfall auch nicht mit PHP, trotzdem habe ich versucht, mich an aktuelle Webstandarts, sowie Richtlinien aus anderen Programmiersprachen/Frameworks zu halten. 
Im aktuellen Stand bin ich mit dem Code selber nicht zufrieden, aber das soll euch ja an nichts hindern.

# Features
Hier sind ein paar Features aufgelistet, welche nicht alle vollständig implementiert worden sind. 

 * Guthabensystem
 * Genaue Statistiken
 * Produkte und Kategorien dynamisch verwalten
 * Updates und (selbstverfasste) News werden auf der Startseite angezeigt
 * Dynamische Produktvorschläge auf der Startseite
 * Support-System mit vorgefertigten Texten um schneller antworten zu können
 * Guthaben via PayPal aufladen
 * Basierend auf MySQL/MariaDB
 * Produkte vor der Veröffentlichung hochladen
 * Einfaches Rechtesystem
 * Update-Notes
 * Preisnachlass für Benutzer mit einer bestimmten Berechtigung
 * Einfache Bedienung

# ToDo
Ich würde mich freuen, wenn Personen, die motivierter als ich sind, an der Codebasis weiterentwickeln würden, damit andere den Shop benutzen können. Ich akzeptiere anständige Pull-Requests!
 
 * Produktdownload
 * Produkt-ACP
 * Senden von Emails
 * Mitteilungsseiten (Guthaben erfolgreich aufgeladen, erfolgreich registriert, etc.)
 * Designbugs beheben
 * Statistiken genauer anzeigen
 * Berechtigungs-Rabatte
 * Kleinkram, der mir nicht einfällt
 
 Falls euch noch weitere Sachen auffallen, erstellt bitte einen Issue, damit alle auf die Informationen zugreifen können.
 
Als wichtiger Hinweis für Interessierte: die Datenbankstruktur ist für weitere Features ausgelegt, die ggf. in der Zukunft erschienen wären, deshalb sind die Grundlagen für verschiedene Arten von Käufen und verschiedene Plugin-Ersteller in der Datenbank vorgesehen.

# Demo
Hier kannst du dir den Shop einfach mal anschauen.

* Benutzer: **Admin** Passwort: **test123**
* Benutzer: **User**  Passwort: **demo**

Zu der Demoseite Vorübergehend offline

# Sicherheit
Beim Entwickeln des Webshops war mir die Sicherheit (vorallem im bezug auf Transaktionen) besonders Wichtig. Daher können nur angemeldete Transaktionen als getätigt gekennzeichnet und dadurch das Guthaben gutgegeschrieben werden. Dabei wird die Zahlung beim Zahlungsanbieter erneut überprüft.
Es war auch ein entsprechendes Anti-Leak bzw. ein System, mit dem man die heruntergeladenen Produkte einem Kunden zuordnen konnte, geplant und halb implementiert, welches ich hier nicht zur verfügung stelle (überlegt euch selber was).

# Setup
Um die Software benutzen zu können, müsst ihr im **assets**-ordner die config.sample.php zu config.php umbenennen und die angeforderten Werte eintragen. Um die Datenbank vorzubereiten befundet sich bei **assets/downloads** eine sql Datei, die die auszuführenden Querys um die Datenbankstruktur zu erstellen beinhaltet. Der erste Account der sich registriert erhält alle Berechtigungen.

# Sonstiges
Ich arbeite derzeit an einer besseren und vor allem (in meinen Augen) schöneren Shopsoftware. Über die Veröffentlichung dieser, mache ich mir zu gegebenem Zeitpunkt gedanken, falls ihr coole Ideen für diese haben solltet, teielt es mir gerne mit.

PS: Viele der Features, die ich mir ursprünglich für DeinPlugin überlegt habe, werden in der neuen Shopsoftware einen guten Platz finden.
