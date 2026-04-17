import requests

file = open("wordpress_db.sql", "w", encoding="utf-8")

file.write("INSERT INTO wordpress_items (name, slug, version, description, source) VALUES\n")

plugins = []
themes = []
page = 1

while len(plugins) < 300:
    url = "https://api.wordpress.org/plugins/info/1.2/"
    params = {
        "action": "query_plugins",
        "request[page]": page,
        "request[per_page]": 100
    }

    res = requests.get(url, params=params).json()

    for p in res["plugins"]:
        plugins.append(p)

    page += 1

page = 1

while len(themes) < 300:
    url = "https://api.wordpress.org/themes/info/1.2/"
    params = {
        "action": "query_themes",
        "request[page]": page,
        "request[per_page]": 100
    }

    res = requests.get(url, params=params).json()

    for p in res["themes"]:
        themes.append(p)

    page += 1

rows = []

for p in plugins[:300]:
    name = p["name"].replace("'", "''")
    slug = p["slug"]
    version = p["version"]
    desc = p["description"].replace("'", "''")

    row = f"('{name}', '{slug}', '{version}', '{desc}', 'wordpress.org')"
    rows.append(row)

for t in themes[:300]:
    name = t["name"].replace("'", "''")
    slug = t["slug"]
    version = t["version"]
    desc = t["description"].replace("'", "''")

    row = f"('{name}', '{slug}', '{version}', '{desc}', 'wordpress.org')"
    rows.append(row)

file.write(",\n".join(rows) + ";")
file.close()

print("Done: wordpress_db.sql created")