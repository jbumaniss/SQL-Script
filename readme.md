#### Izveidots PHP skripts, kas savienojas ar datubāzi, izvelk visus produktus un saglabā tos XML failā products.xml. Fails saglabāts tajā pašā mapē, kur php skripts.
##### Produkti no example tabulām `product`. 
##### To apraksti `product_description` 
##### Un atlaides `product_special`.

---

### XML failā izvadīti šādi dati:
#### 1) :model: - produkta artikuls no `product.model` lauka.
#### 2) :status: - statuss ieslēgts/izslēgts, ko apzīmē ar 1 vai 0. `product.status` lauks.
#### 3) :name: - nosaukums katrā no 3 valodām. Atrodas `product_description` tabulā.
#### 4) :namelv: - latviešu (lv) = 1
#### 5) :nameeng: - angļu (eng) = 2
#### 6) :nameru: - krievu (ru) = 3
#### 7) :description: - apraksts katrā no 3 valodām. Atrodas `product_description` tabulā. Apraksts pirms izvades saīsināts lidz max 200 rakstzīmēm un beigās pielikti daudzpunkti (...). Vārdi netiek pārrauti to vidū.
#### 4) :descriptionlv: latviešu (lv) = 1
#### 5) :descriptioneng: angļu (eng) = 2
#### 6) :descriptionru: krievu (ru) = 3
#### 8) :quantity: - produkta atlikums no `product.quantity`.
#### 9) :ean: - svītrkods no `product.ean`
#### 10) :image_url: - attēla path no `product.image`, kuram priekšā pielikts bāzes URL 'https://www.webdev.lv/'.
#### 8) :date_added: - pievienošanas datums no lauka `product.date_added` formātā d-m-Y.
#### 9) :price: - cena no `product.price`.
#### 10) :special_price: - cena no `product_special`, ja šodienas datums (NOW) ir mazāks vai vienāds ar `date_end`.

#### Visas cenas no datubāzes izvadītas ar plus PVN 21%. noapaļotas līdz diviem cipariem aiz komata. Cipariem aiz komata ir arī tad, ja tie ir nulles.

---

##### Skripts darbojas ar MySQL versiju 5.7.39 un PHP 7.4
