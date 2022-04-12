import pyAesCrypt
password = "strongpassword"
pyAesCrypt.encryptFile("credentials.txt", "credentials.txt.aes", password)