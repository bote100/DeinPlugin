# DeinPlugin
Hier ist der *unfertige* sourcecode von meiner Implementation des DeinPlugin Shops für Pascal, da dieser den Shop nicht mehr abnimmt, stelle ich den aktuellen Fortschritt allen zur Verfügung, die sich den Code mal anschauen wollen.

# Disclaimer
Ich bin kein professioneller WebEntwickler und arbeite im Normalfall auch nicht mit PHP, trotzdem habe ic versucht, mich an aktuelle Richtlinien aus anderen Programmiersprachen/Frameworks zu halten. 
Im aktuellen Stand bin ich mit dem Code selber nicht zufrieden, aber das soll euch ja an nichts hindern.

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
 
Als wichtiger Hinweis für Interessierte: die Datenbankstruktur ist für weitere Features ausgelegt, die ggf. in der Zukunft erschienen wären, deshalb sind die Grundlagen für verschiedene Arten von Käufen und verschiedene Plugin-Ersteller in der Datenbank vorgesehen.

# Sicherheit
Beim Entwickeln des Webshops war mir die Sicherheit (vorallem im bezug auf Transaktionen) besonders Wichtig. Daher können nur angemeldete Transaktionen als getätigt gekennzeichnet werden. Dabei wird die Zahlung beim Zahlungsanbieter erneut überprüft.
Es war auch ein entsprechendes Anti-Leak bzw. ein System, mit dem man die Produkte dem Kunden zuordnen konnte, geplant und halb mplementiert, welches ich hier nicht zur verfügung stelle.

# Sonstiges
Ich arbeite derzeit an einer besseren und vor allem (in meinen Augen) schöneren Shopsoftware, über die Veröffentlichung dieser, mache ich mir zu gegebenem Zeitpunkt gedanken, falls ihr jedoch coole Ideen für die Shosoftware haben solltet, teielt es mir gerne mit.

PS: Viele der Features, die ich mir ursprünglich für DeinPlugin überlegt habe, werden in der neuen Shopsoftware einen guten Platz finden.
