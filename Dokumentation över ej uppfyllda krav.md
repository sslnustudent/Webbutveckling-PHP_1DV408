Krav som behöver rättas till
============================

> Testfall 2.2 - Fel i sessionen då den lever vidare trots att alla fönster och webbläsaren stängs ner. Användaren är fortfarande 
> inloggad med samma PHPSESSID när applikationen öppnas i ny webbläsare. 

> Testfall 3.2 - Fel i hantering av cookies då vid omladdning av sidan vid "Håll mig inloggad" kommer först felmeddelandet "Felaktig
> information i cookie" upp men laddas sidan om en gång till så är Admin inloggad trots att det inte ligger några cookies kvar
> förutom PHPSESSID. Antar att felet ligger i if-satsen i kontrollen för denna funktion.

> Testfall 3.3 - Även här ligger det något fel i cookies då vid borttag av PHPSESSID och sidan laddas om dyker felmeddelandet 
> "Felaktig information i cookie" upp. Antar att felet ligger i if-satsen i kontrollen för denna funktion precis som för testfall
> 3.2. Detta testfall fungerade ett tag men allt eftersom jag byggde på koden för att uppfylla 3.4, 3.5 och 3.6 har det helt
> plötsligt slutat att fungera så vet inte om det kan ha något med cookietoken att göra.

> Testfall 3.6 - Försökte även här använda mig av token men fick inte det att fungera så har inte uppdaterat någon lösning ännu
> för detta testfall. 
