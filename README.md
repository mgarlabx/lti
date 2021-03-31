Learning Tools Interoperability (LTI)
=====================================

Padrão para desenvolvimento de integração
-----------------------------------------

 

Maurício Garcia, 31/03/2021

 

INTRODUÇÃO
----------

 

Learning Tools Interoperability (LTI) é uma especificação desenvolvida pelo IMS Global Learning Consortium.

<http://www.imsglobal.org/activity/learning-tools-interoperability>

 

A LTI estabelece um padrão para integrar fornecedores de conteúdo ("providers") com ambientes de aprendizagem ("consumers"). Muitas editoras ("publishers") disponibilizam seus conteúdos como "providers" usando o padrão LTI, para que ele possa ser consumido por Learning Management Systems (LMS) que possuem esse padrão. Moodle, Canvas e Blackboard são exemplos de "consumers" que operam usando o padrão LTI.

 

Atualmente o "consumer" passou a ser chamado de "Learning Platform" e o "provider" agora é "Learning Tool".

 

CONSUMER / PLATFORM
-------------------

 

O processo é muito simples, basicamente o "consumer" executa um POST no "provider", passando vários parâmetros e ao final uma assinatura. Essa assinatura é criptografia dos parâmetros do POST ordenados e concatenados. A criptografia usa o método HMAC-SHA1 valendo-se de uma senha ("secret") que deve ser fornecida pelo "provider" (é uma autenticação OAuth 1.0).

 

Tipicamente, o "provider" deve fornecer 3 informações:

 

1.  A URL do POST

2.  A chave do "consumer" ("Consumer Key" ou "oauth_consumer_key")

3.  A senha do "consumer" ("Consumer Secret")

 

O arquivo **/consumer/index.php** tem um exemplo de como criar o POST. Atenção apenas para os casos em que é necessário que a URL contenha parâmetros (query string). Os providers possuem requisitos distintos nesses casos.

 

Esse arquivo está rodando em <https://mgar2.websiteseguro.com/lti/consumer/>

 

Outros exemplos de códigos para baixar e rodar localmente existem em:

 

**PHP**

<https://gist.github.com/matthanger/1171921>

<https://acrl.ala.org/techconnect/post/making-a-basic-lti-learning-tools-intoperability-app/>

<https://github.com/Harvard-ATG/workshop-lti-basic>

 

**JAVASCRIPT**

<https://medium.com/lcom-techblog/simple-lti-tool-consumer-in-html-and-javascript-72ca153d7a83>

 

Além dos códigos acima, exemplos de consumers para fins de testes podem ser encontrados em:

 

<https://saltire.lti.app/platform>

<https://ltiapps.net/test/tc.php>

<https://www.tsugi.org/lti-test/lms.php>

 

 

PROVIDER / TOOL
---------------

 

O provider deve ler todas variáveis do POST e calcular a assinatura usando as mesmas "key" e "secret". Depois, deve comparar essa assinatura calculada com a assinatura postada no parâmetro "oauth_signature". Se forem iguais, o POST é válido.

 

O arquivo **/provider/index.php** tem um exemplo de como validar o POST.

 

Esse arquivo está rodando em <https://mgar2.websiteseguro.com/lti/provider/>

 

Esse exemplo exibe o conteúdo postado. Útil para visualizar os parâmetros que foram enviados pelo consumer.

 

Além do código acima, exemplos de provider para fins de testes podem ser encontrados em:

 

<https://saltire.lti.app/tool>

<https://lti.tools/test/tp.php>

<https://ltiapps.net/test/tp.php>

 

 

 

 

