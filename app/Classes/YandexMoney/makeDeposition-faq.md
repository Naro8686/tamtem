Пример makeDeposition в демо с помощью curl и дешифровка полученного ответа c помощью openssl
=============================================================================================

###  Файлы
req.xml - тело запроса (см. пример ниже)
req_signed.txt - упакованный запрос
you.cer - сертификат, который выдал Яндекс.Деньгами, вам, после того, как вы прислали нам файл вашего CSR-запроса
private.key - ваш файл секретного ключа, на основе которого вы сделали CSR-запрос, и мы (Яндекс.Деньги) на основе него сделали you.cer
 
 
### Упаковка запроса
openssl smime -sign -in req.xml -nointern -nodetach -nocerts -nochain -outform PEM -out req_signed.txt -signer you.cer -inkey private.key -passin pass:HIDDEN
 
### Отправка запроса
curl -X POST --insecure -F file=@req_signed.txt --header "Content-type:application/pkcs7-mime" --cert you.cer --key private.key --pass HIDDEN --url https://calypso.yamoney.ru:9094/webservice/deposition/api/makeDeposition
  
### Важно про упаковку запроса
В lunix|unix параметр файла передаем так: "-F file=@req_signed.txt". В Windows "--data-ascii @req_signed.txt".
 
### Пример тела запроса (файл req.xml)
<?xml version="1.0" encoding="UTF-8"?>
<makeDepositionRequest agentId="00000" dstAccount="257003392579" requestDT="2015-11-26T12:09:36.000Z" amount="200.00" clientOrderId="7093BCF45E8046ECB675" currency="10643" contract="Договор средств N 123 от 22.08.2015">
        <paymentParams>
                <skr_destinationCardSynonim>dN3VdS7WchWKmWIUfPmcMUUQpikZ.SC.201211</skr_destinationCardSynonim>
                <pdr_birthDate>01.01.2000</pdr_birthDate>
                <pdr_birthPlace>поселок Забайкальского края</pdr_birthPlace>
                <pdr_lastName>Петров</pdr_lastName>
                <pdr_firstName>Андрей</pdr_firstName>
                <pdr_middleName>Александрович</pdr_middleName>
                <pdr_docNumber>123123123</pdr_docNumber>
                <pdr_docIssueYear>2015</pdr_docIssueYear>
                <pdr_docIssueMonth>8</pdr_docIssueMonth>
                <pdr_docIssueDay>12</pdr_docIssueDay>
                <pdr_docIssuedBy>УВД РОВД, город Саратов</pdr_docIssuedBy>
                <pdr_city>Новосибирск</pdr_city>
                <pdr_postcode>630092</pdr_postcode>
                <pdr_address>Новосибирская обл,  Новосибирск,  ул. Ольги Ивановны,  дом 4,  кв. 5</pdr_address>
                <smsPhoneNumber>79501231212</smsPhoneNumber>
                <pof_offerAccepted>1</pof_offerAccepted>
                <pdr_country>643</pdr_country>
        </paymentParams>
</makeDepositionRequest>
  
### Возможные ошибки
- Используйте в качестве номера знак N (не используйте спецсимвол №).
- <paymentParams></paymentParams> не забывайте, что все дополнительные параметры должны быть обрамлены этим тегом

### Дешифровка ответа на makeDeposition
пример makeDeposition в демо с помощью curl и дешифровка полученного ответа c помощью openssl
# Отправляем запрос на сервер и сохраняем полученный ответ в файл resp.txt
curl -k --cert you.cer --key private.key  -F " file=@out.txt " https://calypso:9094/webservice/deposition/api/makeDeposition > resp.txt
  
### Дешифровка ответа
openssl smime -verify -noverify -inform PEM -nointern -certfile "depositSignature.cer" -CAfile "depositSignature.cer" < resp.txt
  
### resp.txt
-----BEGIN PKCS7-----
MIAGCSqGSIb3DQEHAqCAMIACAQExCzAJBgUrDgMCGgUAMIAGCSqGSIb3DQEHAaCA
JIAEgcU8ZXJyb3JEZXBvc2l0aW9uTm90aWZpY2F0aW9uUmVxdWVzdCBjbGllbnRP
cmRlcklkPSIyNTNhMzk1Ny0xNjA5LTQ3ODQtYjRlZC1iYjRhNmY2ODgzYzciIHJl
cXVlc3REVD0iMjAxNi0wNC0wNFQxMjowMzowMi43ODlaIiBkc3RBY2NvdW50PSIy
NTcwMDMzOTI1NzkiIGFtb3VudD0iMTM2LjYyIiBjdXJyZW5jeT0iMTA2NDMiIGVy
cm9yPSIzMSIvPgAAAAAAADGCAjcwggIzAgEBMIGEMHwxCzAJBgNVBAYTAlJVMQ8w
DQYDVQQIEwZSdXNzaWExGTAXBgNVBAcTEFNhaW50LVBldGVyc2J1cmcxGDAWBgNV
BAoTD1BTIFlhbmRleC5Nb25leTEQMA4GA1UECxMHVW5rbm93bjEVMBMGA1UEAxMM
WWFuZGV4Lk1vbmV5AgRND18oMAkGBSsOAwIaBQCggYgwGAYJKoZIhvcNAQkDMQsG
CSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMTYwNDA0MTIwMzAyWjAjBgkqhkiG
9w0BCQQxFgQUBeVNe6OQrdPV0tgnIMRchvOeMSUwKQYJKoZIhvcNAQk0MRwwGjAJ
BgUrDgMCGgUAoQ0GCSqGSIb3DQEBAQUAMA0GCSqGSIb3DQEBAQUABIIBAJnDA4FJ
w9xd3aH+Q5Zvubrbaf9jci89coST+ySqXbyCI/htgEqHXlapsu256wF+bzTQJM/X
QXj14aP/X7v8JIE937GbldpeyUlWIhbyaw1odL8pnw60nNd9hG11Rav3OmF2l4Xe
jH9VelknKY/IXFWPUK25NkTSHtR28Ze9C1NIE87hmsgq2M6QOnoWITzYL2BM6KtG
1PZKDB0HpqRDw89SjdSeMI+dNet8VSyvmLtR/i8Dr7EWN7+G1tqCi7V4UveWlTKt
O7MZyy3xg64XeaDqG+eD6/3D9GN8Q7J3KDNK9SdjqbmQY6qFCNq1BGEb0zHOs7Ae
9iRii8sV+d9dLywAAAAAAAA=
-----END PKCS7-----
Файл depositSignature.cer - это файл открытого ключа демо среды. Вам его направляет менеджер или техник, после настройки шлюза.

### Дешифровка ответа
curl -X POST --insecure --data-ascii @req_signed.txt --header "Content-type:application/pkcs7-mime" --url http://domain.com/errorDepositionNotificationRequest
resp.txt
-----BEGIN PKCS7-----
MIAGCSqGSIb3DQEHAqCAMIACAQExCzAJBgUrDgMCGgUAMIAGCSqGSIb3DQEHAaCA
JIAEgcU8ZXJyb3JEZXBvc2l0aW9uTm90aWZpY2F0aW9uUmVxdWVzdCBjbGllbnRP
cmRlcklkPSIyNTNhMzk1Ny0xNjA5LTQ3ODQtYjRlZC1iYjRhNmY2ODgzYzciIHJl
cXVlc3REVD0iMjAxNi0wNC0wNFQxMjowMzowMi43ODlaIiBkc3RBY2NvdW50PSIy
NTcwMDMzOTI1NzkiIGFtb3VudD0iMTM2LjYyIiBjdXJyZW5jeT0iMTA2NDMiIGVy
cm9yPSIzMSIvPgAAAAAAADGCAjcwggIzAgEBMIGEMHwxCzAJBgNVBAYTAlJVMQ8w
DQYDVQQIEwZSdXNzaWExGTAXBgNVBAcTEFNhaW50LVBldGVyc2J1cmcxGDAWBgNV
BAoTD1BTIFlhbmRleC5Nb25leTEQMA4GA1UECxMHVW5rbm93bjEVMBMGA1UEAxMM
WWFuZGV4Lk1vbmV5AgRND18oMAkGBSsOAwIaBQCggYgwGAYJKoZIhvcNAQkDMQsG
CSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMTYwNDA0MTIwMzAyWjAjBgkqhkiG
9w0BCQQxFgQUBeVNe6OQrdPV0tgnIMRchvOeMSUwKQYJKoZIhvcNAQk0MRwwGjAJ
BgUrDgMCGgUAoQ0GCSqGSIb3DQEBAQUAMA0GCSqGSIb3DQEBAQUABIIBAJnDA4FJ
w9xd3aH+Q5Zvubrbaf9jci89coST+ySqXbyCI/htgEqHXlapsu256wF+bzTQJM/X
QXj14aP/X7v8JIE937GbldpeyUlWIhbyaw1odL8pnw60nNd9hG11Rav3OmF2l4Xe
jH9VelknKY/IXFWPUK25NkTSHtR28Ze9C1NIE87hmsgq2M6QOnoWITzYL2BM6KtG
1PZKDB0HpqRDw89SjdSeMI+dNet8VSyvmLtR/i8Dr7EWN7+G1tqCi7V4UveWlTKt
O7MZyy3xg64XeaDqG+eD6/3D9GN8Q7J3KDNK9SdjqbmQY6qFCNq1BGEb0zHOs7Ae
9iRii8sV+d9dLywAAAAAAAA=
-----END PKCS7-----

