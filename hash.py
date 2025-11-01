import getpass
import bcrypt

# the hash you gave
bcrypt_hash = b"$2y$10$uQgX1h5as.74ecgfSb7Ci.KPGcXpH6qOA5PIEEiwkVTgqPAY.r9ZW"

# some bcrypt libraries accept $2y$; if yours errors, uncomment the next line to convert to $2b$:
# bcrypt_hash = bcrypt_hash.replace(b"$2y$", b"$2b$")

pw = getpass.getpass("Enter candidate password: ").encode("utf-8")

if bcrypt.checkpw(pw, bcrypt_hash):
    print("MATCH — the password is correct.")
else:
    print("NO MATCH — that password does not match the hash.")
