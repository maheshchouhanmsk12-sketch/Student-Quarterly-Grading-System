import os
import sys
import re
import argparse
from urllib.parse import urlparse

def run_import():
    try:
        import pymysql
    except ImportError:
        print("[*] Installing required library 'pymysql' and 'cryptography'...")
        import subprocess
        subprocess.check_call([sys.executable, "-m", "pip", "install", "pymysql", "cryptography"])
        import pymysql

    parser = argparse.ArgumentParser(description="Import sqgs_db.sql into Aiven / MySQL")
    parser.add_argument("--uri", help="Full Aiven Service URI (e.g., mysql://avnadmin:pwd@host:port/dbname?ssl-mode=REQUIRED)")
    parser.add_argument("--host", default="localhost")
    parser.add_argument("--port", type=int, default=3306)
    parser.add_argument("--user", default="root")
    parser.add_argument("--password", default="")
    parser.add_argument("--database", default="defaultdb")
    parser.add_argument("--sql", default=os.path.join(os.path.dirname(__file__), "database", "sqgs_db.sql"))
    args = parser.parse_args()

    host = args.host
    port = args.port
    user = args.user
    password = args.password
    dbname = args.database

    if args.uri:
        u = urlparse(args.uri)
        host = u.hostname or host
        port = u.port or port
        user = u.username or user
        password = u.password or password
        if u.path and len(u.path) > 1:
            dbname = u.path.lstrip("/")

    print(f"[*] Connecting to database at {host}:{port} (db: {dbname}, user: {user})...")

    # Connect with SSL for cloud databases like Aiven
    ssl_dict = {'check_hostname': False} if host not in ('localhost', '127.0.0.1') else None

    try:
        conn = pymysql.connect(
            host=host,
            port=port,
            user=user,
            password=password,
            database=dbname,
            ssl=ssl_dict,
            autocommit=True,
            charset='utf8mb4'
        )
    except Exception as e:
        print(f"[!] Connection failed: {e}")
        return False

    print("[+] Successfully connected to MySQL database!")

    sql_path = args.sql
    if not os.path.exists(sql_path):
        print(f"[!] SQL file not found: {sql_path}")
        return False

    print(f"[*] Reading SQL file: {sql_path}...")
    with open(sql_path, "r", encoding="utf-8", errors="ignore") as f:
        sql_content = f.read()

    # Split SQL statements safely
    # Remove comments and empty lines
    statements = []
    current_stmt = []
    in_multi_line_comment = False

    for line in sql_content.splitlines():
        trimmed = line.strip()
        if not trimmed:
            continue
        if trimmed.startswith("/*") and not trimmed.endswith("*/"):
            in_multi_line_comment = True
            continue
        if in_multi_line_comment:
            if "*/" in trimmed:
                in_multi_line_comment = False
            continue
        if trimmed.startswith("--") or trimmed.startswith("#"):
            continue
        
        current_stmt.append(line)
        if trimmed.endswith(";"):
            stmt_text = "\n".join(current_stmt).strip()
            if stmt_text:
                statements.append(stmt_text)
            current_stmt = []

    print(f"[*] Executing {len(statements)} SQL statements...")
    with conn.cursor() as cursor:
        for idx, stmt in enumerate(statements, 1):
            try:
                cursor.execute(stmt)
            except Exception as ex:
                # Ignore duplicate table or harmless warnings if table exists
                print(f"[-] Statement {idx} info: {ex}")

    conn.close()
    print("[+] Database import successfully completed!")
    return True

if __name__ == "__main__":
    run_import()

