# NDC Drug Search App

Aplikacion Laravel me Livewire per kerkimin e ilaçeve sipas kodit NDC. Lejon kerkim ne databaze lokale dhe OpenFDA API, ruajtje automatike, eksportim ne CSV, dhe kontroll te rezultateve.
Jan te perfunduara te gjitha Kerkesat shtese dhe piket bonus/

---

## ⚙️ Udhezime Instalimi (Hap pas Hapi)

### 1️⃣ Klono projektin


git clone https://github.com/banibuja/ndc-search.git
cd ndc-search


### 2️⃣ Instalo varesite


composer install
npm install && npm run build


### 3️⃣ Krijo `.env` dhe gjenero çelesin


cp .env.example .env
php artisan key:generate


### 4️⃣ Konfiguro databazen

Ne `.env` vendos kredencialet per databazen MySQL dhe krijo databazen ndc_search, pastaj:

<!-- DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ndc_search
DB_USERNAME=root
DB_PASSWORD= -->


php artisan migrate --seed


### 5️⃣ Nis vite dhe serverin lokal


npm run dev

### hap terminal tjeter per server

php artisan serve




Aksesojeni ne [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🔍 Pershkrim i Logjikes se Implementuar

### ✅ Autentifikim & Regjistrim

- Laravel Breeze me Livewire/Volt
- Pas regjistrimit, perdoruesi ridrejtohet automatikisht ne faqen kryesore `/`

### ✅ Kerkimi i ilaçeve

- Fusha per futjen e nje ose me shume kodeve NDC (te ndara me presje)
- Perdoruesi mund te kerkoje per `12345-6789`, `11111-2222`, etj.
- Kerkimi kontrollon:
  - 📦 Se pari ne databazen lokale
  - 🌐 Ne [OpenFDA API](https://api.fda.gov/drug/ndc.json) nese nuk gjenden
- Rezultatet e reja ruhen ne databaze per perdorim te ardhshem

### ✅ Funksionalitete te avancuara

| Funksioni         | Pershkrim                                                                    |
| ----------------- | ---------------------------------------------------------------------------- |
| 🔄 Spinner        | Tregon “Duke kerkuar…” gjate procesit te kerkimit                            |
| 📄 Eksport ne CSV | Eksporto vetem rezultatet e fundit ne nje file `.csv`                        |
| 🧹 Fshirje        | Fshi çdo rresht nga databaza ne menyre individuale                           |
| 📑 Paginim        | Kur hapet aplikacioni, shfaqen vetem 5 rreshta per faqe                      |
| 📦 Burimi         | Tregohet per çdo rresht nese vjen nga `Database`, `OpenFDA`, apo `Not Found` |

---

## 💡 Ide per permiresime te ardhshme

- 🔎 Filter per burimin e te dhenave (`Database`, `OpenFDA`)
- 🕒 Historik i kerkimeve per çdo perdorues
- 📥 Importim ne mase i kodeve nga file CSV
- 🌙 Dark Mode

---

## 📁 Struktura Kryesore


app/
  └── Livewire/
      └── DrugSearch.php
resources/
  └── views/
      └── livewire/
          └── drug-search.blade.php
routes/
  └── web.php
database/
  └── seeders/
      └── DrugSeeder.php


---

