import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin

url = "https://web.misada.sch.id/main"

response = requests.get(
    url,
    headers={"User-Agent": "Mozilla/5.0"},
    timeout=15
)
response.raise_for_status()

soup = BeautifulSoup(response.text, "html.parser")

# Mengambil seluruh teks
teks = soup.get_text(separator="\n", strip=True)

# Mengambil semua link
links = [
    urljoin(url, a["href"])
    for a in soup.find_all("a", href=True)
]

# Mengambil semua gambar
gambar = [
    urljoin(url, img["src"])
    for img in soup.find_all("img", src=True)
]

# Menyimpan teks
with open("teks_website.txt", "w", encoding="utf-8") as file:
    file.write(teks)

# Menyimpan link
with open("link_website.txt", "w", encoding="utf-8") as file:
    file.write("\n".join(links))

# Menyimpan gambar
with open("gambar_website.txt", "w", encoding="utf-8") as file:
    file.write("\n".join(gambar))

print("Scraping selesai!")
print(f"Jumlah link: {len(links)}")
print(f"Jumlah gambar: {len(gambar)}")
