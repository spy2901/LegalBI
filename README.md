# LegalBI - Business Intelligence sistem za Agenciju za Besplatnu Pravnu Pomoć

## Opis projekta
LegalBI je **Business Intelligence (BI) informacioni sistem** razvijen za analizu i praćenje rada agencije za besplatnu pravnu pomoć.  
Sistem omogućava:

- Praćenje i vizualizaciju ključnih indikatora performansi (KPI)
- Analizu vremena rešavanja slučajeva
- Praćenje opterećenja pravnika
- Analizu teritorijalne raspodele korisnika pravne pomoći
- Upravljanje korisnicima i sigurnim pristupom podacima

Sistem je razvijen u **PHP-u sa MySQL bazom** i koristi proceduralni pristup za jednostavnu implementaciju i skalabilnost.

---

## Tehnološki okvir

- PHP 7.4+  
- MySQL / MariaDB  
- HTML5, CSS3, JavaScript (Chart.js za grafike)  
- Apache ili bilo koji web server sa PHP podrškom  

---

## Struktura projekta

/legalbi/
│
├── config/
│   └── db.php            <- konekcija sa MySQL
│
├── public/
│   ├── index.php         <- dashboard (za ulogovane)
│   ├── login.php         <- forma za login
│   ├── logout.php        <- logout
│   └── assets/
│       ├── style.css
│       └── charts.js
│
├── includes/
│   ├── auth.php          <- login, sesije, provera pristupa
│   ├── helpers.php       <- funkcije za KPI, filtriranje podataka
│   └── etl.php           <- (opcionalno) ETL skripte
│
└── modules/
    ├── dashboard.php     <- generisanje KPI i grafika
    └── reports.php       <- detaljni izveštaji

---

## Instalacija

1. **Preuzmite ili klonirajte projekat**
```bash
git clone <repo-url>
Kreirajte MySQL bazu

CREATE DATABASE legalbi;
Importujte tabele

Tabela sa slučajevima (bpp)

Tabela sa korisnicima (korisnici)

Konfigurišite konekciju

Otvorite config/db.php i podesite host, username, password i dbname

Pokrenite web server

Preko XAMPP, MAMP ili Apache

Otvorite http://localhost/legalbi/public/login.php

Korišćenje
Prijava

Korisnici se prijavljuju preko forme u login.php

Uloge:

admin – kompletan pristup

analiticar – pristup KPI i grafikonima

operativni – unos novih slučajeva

Dashboard

Prikazuje KPI kartice, linijske grafove i pie chart-ove

Omogućava pregled i filtriranje slučajeva

Izveštaji

Detaljni izveštaji po pravniku, vrsti prava i periodu

Sigurnost
Lozinke se čuvaju hashovane (password_hash)

Pristup dashboardu i podacima je ograničen PHP sesijama

Podaci u bazi su pseudonimizovani i bezbedni

