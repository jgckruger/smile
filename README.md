# SMILE

SMILE é um projeto feito pelo aluno João Gabriel Corrêa Krüger para a disciplina de Projeto de Sistemas de Informação do curso de Engenharia de Computação da Universidade Estadual de Ponta Grossa (UEPG).

O SMILE tem como proposta ser uma solução para os seguintes problemas no NUTEAD

  - Evasão durante o período de trabalho por parte dos funcionários
  - Identificação dos funcionários saindo e entrando do NUTEAD
  - Registro das horas de entrada e saída dos funcionários do NUTEAD
  - Captura de fotos dos transeuntes
  - Possibilitar identificação de visitas indesejadas

# Tecnologias usadas

O SMILE é desenvolvido usando as seguintes ferramentas e linguagens
  - [PHP]  7.0.20-2 - Linguagem de programação usada no NUTEAD
  - [MySQL] Ver 14.14 Distrib 5.7.18 para Linux (x86_64) - Banco de dadoso com o nível de desempenho e robustez suficientes para o trabalho
  - [Apache2] 2.4.27 - Servidor WEB amplamente adotado
  - Biblioteca para o uso do microcontrolador [ESP8266] - Similar aos Atmega, só que com conexão Wi-Fi embutida =D
  - [Arduino IDE] - Ambiente de desenvolvimento simples e intuitivo para a programação do ESP8266
  - Leitor RFID [RC522] - Leitor de RFID barato e prático de usar
  - Cartões [RFID MiFare] - Cartões de RFID compatíveis com o leitor RC522

### Instalação

TODO
Instalando as dependências para ambiente de desenvolvimento.

```sh
$ sudo apt install apache2
$ comandos
$ comandos aqui
```

Para ambiente de produção...

```sh
$ npm install --production
$ NODE_ENV=production node app
```
### Desenvolvimento

Quer contribuir? Legal!
Clone o repositório e envie os commits que será feita a avaliação das alterações

### Acesso local
Verifique se o deploy foi correto acessando.

```sh
127.0.0.1
```

### TODO

 - Escrever sobre o phpmyadmin
 - Escrever a lógica de detecção de entrada
 - Escrever o envio do RFID por GET
 - Subir o programa do ESP8266
 - Terminar o CRUD dos funcionários
 - Começar o CRUD do RFID, visitantes
 - Criar tela para mostrar os horários de entrada e saída dos funcionários em específico
 - Manipular as câmeras IP
 - Associar as fotos as passagens
 - Disponibilizar comandos de instalação

**Dúvidas ou sugestões contatar no Github ou no email jgckruger@uol.com.br!**

[//]: # (Referências e links para o Markdown linkar)


   [PHP]: <https://php.net>
   [MySQL]: <https://www.mysql.com>
   [Apache2]: <https://httpd.apache.org>
   [ESP8266]: <https://www.espressif.com/sites/default/files/documentation/0a-esp8266ex_datasheet_en.pdf>
   [Arduino IDE]: <https://www.arduino.cc/en/main/software>
   [RC522]: <https://www.nxp.com/docs/en/data-sheet/MFRC522.pdf>
   [RFID MiFare]: <https://en.wikipedia.org/wiki/MIFARE>

