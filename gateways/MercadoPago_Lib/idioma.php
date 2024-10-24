<?php
function traduccion($idioma, $texto)
{
    //es-AR
    $textos["ar"]["mpconfig_2"] = "Repositorio Oficial";    
    $textos["ar"]["mpconfig_4"] = "Ayuda";
    $textos["ar"]["mpconfig_5"] = "Obtener datos según país";
    $textos["ar"]["mpconfig_6"] = "Cerrar";
    $textos["ar"]["mpconfig_7"] = "Es el código privado que se utiliza para conectarse a la API de MercadoPago.<br>\r\n    Para conseguirlo debe estar logueado en MercadoPago y luego hacer clic en el botón <b>Obtener dato</b>.<br>\r\n    Obtenga el Token desde la sección [Credenciales de Producción].";
    $textos["ar"]["mpconfig_8"] = "Copie el código sin modificarlo en el espacio provisto.";
    $textos["ar"]["mpconfig_9"] = "Destino para pagos exitosos";
    $textos["ar"]["mpconfig_10"] = "Destino para pagos pendientes";
    $textos["ar"]["mpconfig_11"] = "Destino para pagos fallidos";
    $textos["ar"]["mpconfig_12"] = "En el formato https://www.dominio.ext/xxx.ext Dejar en blanco para redirección por defecto.";
    $textos["ar"]["mpconfig_13"] = "Título de la factura";
    $textos["ar"]["mpconfig_14"] = "Ej. Factura, Boleta, Orden de Pago, etc.<br>Aparecerá acompañado del nombre de la empresa y el número de factura, por ej: Empresa XXXX - Orden de Pago Nro. 9999";
    $textos["ar"]["mpconfig_15"] = "Texto del botón de pago";
    $textos["ar"]["mpconfig_16"] = "Pagar Ahora";
    $textos["ar"]["mpconfig_17"] = "Color del botón"; 
    $textos["ar"]["mpconfig_18"] = "Celeste";
    $textos["ar"]["mpconfig_19"] = "Gris";
    $textos["ar"]["mpconfig_20"] = "Verde";
    $textos["ar"]["mpconfig_21"] = "Rojo";
    $textos["ar"]["mpconfig_22"] = "Amarillo";
    $textos["ar"]["mpconfig_23"] = "Teal";
    $textos["ar"]["mpconfig_24"] = "Blanco";
    $textos["ar"]["mpconfig_25"] = "Negro";
    $textos["ar"]["mpconfig_26"] = "Solo link";
    $textos["ar"]["mpconfig_27"] = "Seleccione el color del botón de pago";
    $textos["ar"]["mpconfig_28"] = "Nota bajo botón";
    $textos["ar"]["mpconfig_29"] = "Esta nota aparecerá bajo el botón de cobro. [Opcional]";
    $textos["ar"]["mpconfig_30"] = "Excluir tarjetas de crédito";
    $textos["ar"]["mpconfig_31"] = "Marcando esta casilla se excluirán las tarjetas de crédito de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_32"] = "Excluir tickets";
    $textos["ar"]["mpconfig_33"] = "Marcando esta casilla se excluirán los tickets de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_34"] = "Excluir cobro bancario";
    $textos["ar"]["mpconfig_35"] = "Marcando esta casilla se excluirán los cobros bancarios de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_36"] = "Excluir tarjetas de débito";
    $textos["ar"]["mpconfig_37"] = "Marcando esta casilla se excluirán las tarjetas de débito de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_38"] = "Excluir tarjetas prepagas";
    $textos["ar"]["mpconfig_39"] = "Marcando esta casilla se excluirán las tarjetas prepagas de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_40"] = "Excluir transferencias bancarias";
    $textos["ar"]["mpconfig_41"] = "Marcando esta casilla se excluirán las transferencias bancarias de la lista de medios de pago habilitados.";
    $textos["ar"]["mpconfig_42"] = "Comportamiento del módulo";
    $textos["ar"]["mpconfig_43"] = "Modo normal";
    $textos["ar"]["mpconfig_44"] = "Excluir verificación";
    $textos["ar"]["mpconfig_45"] = "Total truncado";
    $textos["ar"]["mpconfig_46"] = "Total redondeado";
    $textos["ar"]["mpconfig_47"] = "ATENCIÓN: No modifique esta opción a menos que sea absolutamente necesario.";
    $textos["ar"]["mpconfig_48"] = "No altera el funcionamiento normal del módulo";
    $textos["ar"]["mpconfig_49"] = "El módulo NO verificará la correspondencia entre el cobro acreditado en MercadoPago y el importe original de la factura";
    $textos["ar"]["mpconfig_50"] = "Solo se enviará a MercadoPago la parte entera del importe total. Ej: Importe original = 485.58 --> Importe enviado = 485";
    $textos["ar"]["mpconfig_51"] = "El total de la factura será redondeado. Ej: Total: 651.50 => 652  //  651.70 => 652  //  651.29 => 651.";
    $textos["ar"]["mpconfig_52"] = "Mostrar errores de MercadoPago";
    $textos["ar"]["mpconfig_53"] = "Marcando esta casilla, el módulo <b>NO generará el botón de pago.</b><br>En su lugar, mostrará el mensaje de error proveniente de MercadoPago.<br>Recomendamos NO utilizar esta opción a menos que sea absolutamente necesario";
    $textos["ar"]["mpconfig_54"] = "Modo prueba";
    $textos["ar"]["mpconfig_55"] = "Marcando esta casilla el módulo se ejecutará en modo prueba.";
    $textos["ar"]["mpconfig_56"] = "Factura";
    $textos["ar"]["mpconfig_57"] = "Gateway";
    $textos["ar"]["mpconfig_58"] = "Transaccion";
    $textos["ar"]["mpconfig_59"] = "Comunicacion";
    $textos["ar"]["mpconfig_60"] = "Autorizacion";
    $textos["ar"]["mpconfig_61"] = "Fecha";
    $textos["ar"]["mpconfig_62"] = "Metodo de pago";
    $textos["ar"]["mpconfig_63"] = "Moneda";
    $textos["ar"]["mpconfig_64"] = "Importe";
    $textos["ar"]["mpconfig_65"] = "Neto";
    $textos["ar"]["mpconfig_66"] = "Aprobado";
    $textos["ar"]["mpconfig_67"] = "Provisto por MercadoPago. Este campo solo es requerido en caso de utilizar procesamiento como Gateway. Si no sabe a qué se refiere, déjelo en blanco.";
    $textos["ar"]["mpconfig_68"] = "El modo normal es Aggregator. NO modifique esta opción a menos que sea absolutamente necesario.";
    $textos["ar"]["mpconfig_69"] = "Ventana de Sistema";
    $textos["ar"]["mpconfig_70"] = "Callback Email";
    $textos["ar"]["mpconfig_71"] = "Si completa este campo, se activará el sistema de log del callback.<br>Se enviarán, por correo electrónico, distintos parámetros sobre las comunicaciones recibidas de MercadoPago.<br>Para el correcto funcionamiento, su servidor debe tener activa la función [mail()] de PHP.<BR>Para deshabilitar esta opción, deje en blanco este campo.";
    $textos["ar"]["mpconfig_72"] = "Nombre de Usuario Administrador de WHMCS. ATENCIÓN: Solo completar si utiliza WHMCS versión 7.2 o inferior.";
    $textos["ar"]["mpconfig_73"] = "Moneda del cliente";
    $textos["ar"]["mpconfig_74"] = "Importe original";
    $textos["ar"]["mpconfig_75"] = "Comisión original";
    $textos["ar"]["mpconfig_76"] = "Pendiente";
    $textos["ar"]["mpconfig_77"] = "Procesamiento de transacciones en cola";
    $textos["ar"]["mpconfig_78"] = "Para evitar transacciones duplicadas, se encolan las transacciones recibidas de MercadoPago y se procesan una a una con el System Cron de WHMCS (cada 5 minutos)";
    $textos["ar"]["mercadopago_config_1"] = "Licencia de uso para los módulos de pago MercadoPago";
    $textos["ar"]["mercadopago_config_2"] = "Licencia";
    $textos["ar"]["mercadopago_config_3"] = "Verificador Local";
    $textos["ar"]["mercadopago_config_4"] = "Código local de verificación de licencia - NO MODIFICAR!";
    $textos["ar"]["mercadopago_config_5"] = "Idioma";
    $textos["ar"]["mercadopago_config_6"] = "Seleccione el idioma de configuración del módulo.";
    $textos["ar"]["mercadopago_activate_1"] = "Activación exitosa: Haga clic en el botón de configuración para modificar las opciones del módulo.";
    $textos["ar"]["mercadopago_deactivate_1"] = "El módulo MercadoPago se desactivó correctamente.";
    //en-US
    $textos["us"]["mpconfig_2"] = "Official Repository";    
    $textos["us"]["mpconfig_4"] = "Help";
    $textos["us"]["mpconfig_5"] = "Show data by country";
    $textos["us"]["mpconfig_6"] = "Close";
    $textos["us"]["mpconfig_7"] = "It is the private code used to connect to the MercadoPago API. <br>\r\n    To do this, you must be logged into MercadoPago and then click on the <b> Get data </b> button. <br>\r\n    Obtain the Token from the [Production Credentials] section.";
    $textos["us"]["mpconfig_8"] = "Paste the code without modifying it in the space provided.";
    $textos["us"]["mpconfig_9"] = "Destination URL for successful payments";
    $textos["us"]["mpconfig_10"] = "Destination URL for pending payments";
    $textos["us"]["mpconfig_11"] = "Destination for failed payments";
    $textos["us"]["mpconfig_12"] = "Use the format https: //www.domain.ext/xxx.ext Leave blank for default redirection.";
    $textos["us"]["mpconfig_13"] = "Invoice title";
    $textos["us"]["mpconfig_14"] = "Eg Invoice, Ticket, Payment Order, etc. <br> It will appear accompanied by the name of the company and the invoice number, eg: Company XXXX - Payment Order No. 9999";
    $textos["us"]["mpconfig_15"] = "Payment button text";
    $textos["us"]["mpconfig_16"] = "Pay Now";
    $textos["us"]["mpconfig_17"] = "Button color";
    $textos["us"]["mpconfig_18"] = "Light blue";
    $textos["us"]["mpconfig_19"] = "Gray";
    $textos["us"]["mpconfig_20"] = "Green";
    $textos["us"]["mpconfig_21"] = "Red";
    $textos["us"]["mpconfig_22"] = "Yellow";
    $textos["us"]["mpconfig_23"] = "Teal";
    $textos["us"]["mpconfig_24"] = "White";
    $textos["us"]["mpconfig_25"] = "Black";
    $textos["us"]["mpconfig_26"] = "Only link";
    $textos["us"]["mpconfig_27"] = "Select the color of the payment button";
    $textos["us"]["mpconfig_28"] = "Note under button";
    $textos["us"]["mpconfig_29"] = "This note will appear under the payment button. [Optional]";
    $textos["us"]["mpconfig_30"] = "Exclude credit cards";
    $textos["us"]["mpconfig_31"] = "Checking this box will exclude credit cards from the list of enabled payment methods.";
    $textos["us"]["mpconfig_32"] = "Exclude tickets";
    $textos["us"]["mpconfig_33"] = "Checking this box will exclude tickets from the list of enabled payment methods.";
    $textos["us"]["mpconfig_34"] = "Exclude bank payments";
    $textos["us"]["mpconfig_35"] = "Checking this box will exclude bank payments from the list of enabled payment methods.";
    $textos["us"]["mpconfig_36"] = "Exclude debit cards";
    $textos["us"]["mpconfig_37"] = "Checking this box will exclude debit cards from the list of enabled payment methods.";
    $textos["us"]["mpconfig_38"] = "Exclude prepaid cards";
    $textos["us"]["mpconfig_39"] = "Checking this box will exclude prepaid cards from the list of enabled payment methods.";
    $textos["us"]["mpconfig_40"] = "Exclude bank transfers";
    $textos["us"]["mpconfig_41"] = "Checking this box will exclude bank transfers from the list of enabled payment methods.";
    $textos["us"]["mpconfig_42"] = "Module behavior";
    $textos["us"]["mpconfig_43"] = "Normal mode";
    $textos["us"]["mpconfig_44"] = "Exclude verification";
    $textos["us"]["mpconfig_45"] = "Total truncated";
    $textos["us"]["mpconfig_46"] = "Total rounded";
    $textos["us"]["mpconfig_47"] = "WARNING: Do not modify this option unless absolutely necessary.";
    $textos["us"]["mpconfig_48"] = "Does not alter the normal operation of the module";
    $textos["us"]["mpconfig_49"] = "The module will NOT verify the correspondence between the payment credited in MercadoPago and the original amount of the invoice";
    $textos["us"]["mpconfig_50"] = "Only the entire part of the total amount will be sent to MercadoPago. Ex: Original amount = 485.58 -> Sent amount = 485";
    $textos["us"]["mpconfig_51"] = "The total of the invoice will be rounded. Ex: Total: 651.50 => 652 // 651.70 => 652 // 651.29 => 651.";
    $textos["us"]["mpconfig_52"] = "Show MercadoPago errors";
    $textos["us"]["mpconfig_53"] = "By checking this box, the module <b> will NOT generate the payment button. </b> <br> Instead, it will display the error message from MercadoPago. <br> We recommend NOT to use this option unless it is absolutely necessary";
    $textos["us"]["mpconfig_54"] = "Sandbox mode";
    $textos["us"]["mpconfig_55"] = "By checking this box the module will run in sandbox mode.";
    $textos["us"]["mpconfig_56"] = "Invoice";
    $textos["us"]["mpconfig_57"] = "Gateway";
    $textos["us"]["mpconfig_58"] = "Transaction";
    $textos["us"]["mpconfig_59"] = "Communication";
    $textos["us"]["mpconfig_60"] = "Autorization";
    $textos["us"]["mpconfig_61"] = "Date";
    $textos["us"]["mpconfig_62"] = "Payment method";
    $textos["us"]["mpconfig_63"] = "Currency";
    $textos["us"]["mpconfig_64"] = "Total";
    $textos["us"]["mpconfig_65"] = "Net";
    $textos["us"]["mpconfig_66"] = "Approved";
    $textos["us"]["mpconfig_67"] = "Provided by MercadoPago. This field is only required in case of using processing as Gateway. If you don't know what it means, leave it blank.";
    $textos["us"]["mpconfig_68"] = "The normal mode is Aggregator. DO NOT modify this option unless absolutely necessary.";
    $textos["us"]["mpconfig_69"] = "System Console";
    $textos["us"]["mpconfig_70"] = "Callback Email";
    $textos["us"]["mpconfig_71"] = "If you fill this field, the callback log system will be activated.<br>Different parameters about the communications received from MercadoPago will be sent by email.<br>For correct operation, your server must have the [mail ()] from PHP.<BR>To disable this option, leave this field blank.";
    $textos["us"]["mpconfig_72"] = "WHMCS Administrator Username. ATTENTION: Only complete if you use WHMCS version 7.2 or lower.";
    $textos["us"]["mpconfig_73"] = "Customer currency";
    $textos["us"]["mpconfig_74"] = "Original amount";
    $textos["us"]["mpconfig_75"] = "Original fee";
    $textos["us"]["mpconfig_76"] = "Pending";
    $textos["us"]["mpconfig_77"] = "Queued transaction processing";
    $textos["us"]["mpconfig_78"] = "To avoid duplicated transactions, transactions received from MercadoPago are queued and processed one by one with the WHMCS System Cron (every 5 minutes)";
    $textos["us"]["mercadopago_config_1"] = "Use license for MercadoPago payment modules";
    $textos["us"]["mercadopago_config_2"] = "License";
    $textos["us"]["mercadopago_config_3"] = "Local Verifier";
    $textos["us"]["mercadopago_config_4"] = "Local License Verification Code - DO NOT MODIFY!";
    $textos["us"]["mercadopago_config_5"] = "Language";
    $textos["us"]["mercadopago_config_6"] = "Select the language for module configuration.";
    $textos["us"]["mercadopago_activate_1"] = "Successful activation: Click the configuration button to modify the module options.";
    $textos["us"]["mercadopago_deactivate_1"] = "The MercadoPago module was successfully disabled.";
    //pt-BR
    $textos["br"]["mpconfig_2"] = "Repositório Oficial";    
    $textos["br"]["mpconfig_4"] = "Ajuda";
    $textos["br"]["mpconfig_5"] = "Obtenha dados por país";
    $textos["br"]["mpconfig_6"] = "Fechar";
    $textos["br"]["mpconfig_7"] = "É o código privado usado para se conectar à API do MercadoPago. <br>\r\n    Para fazer isso, você deve estar logado no MercadoPago e clicar no botão <b> Obter dados </b>. <br>\r\n    Obtenha o token na seção [Credenciais de produção].";
    $textos["br"]["mpconfig_8"] = "Cole o código sem modificá-lo no espaço fornecido.";
    $textos["br"]["mpconfig_9"] = "URL de destino para pagamentos bem-sucedidos";
    $textos["br"]["mpconfig_10"] = "URL de destino para pagamentos pendentes";
    $textos["br"]["mpconfig_11"] = "URL de destino para pagamentos falhados";
    $textos["br"]["mpconfig_12"] = "No formato https: //www.dominio.ext/xxx.ext Deixe em branco para o redirecionamento por padrão.";
    $textos["br"]["mpconfig_13"] = "Título da fatura";
    $textos["br"]["mpconfig_14"] = "Ex: Fatura, Cédula, Ordem de Pagamento, etc. <br> Aparecerá acompanhado do nome da empresa e do número da fatura, por exemplo: Empresa XXXX - Ordem de Pagamento nº 9999";
    $textos["br"]["mpconfig_15"] = "Texto do botão de pagamento";
    $textos["br"]["mpconfig_16"] = "Pagar agora";
    $textos["br"]["mpconfig_17"] = "Cor do botao";
    $textos["br"]["mpconfig_18"] = "Azul claro";
    $textos["br"]["mpconfig_19"] = "Cinzento";
    $textos["br"]["mpconfig_20"] = "Verde";
    $textos["br"]["mpconfig_21"] = "Vermelho";
    $textos["br"]["mpconfig_22"] = "Amarelo";
    $textos["br"]["mpconfig_23"] = "Teal";
    $textos["br"]["mpconfig_24"] = "Branco";
    $textos["br"]["mpconfig_25"] = "Preto";
    $textos["br"]["mpconfig_26"] = "Solo link";
    $textos["br"]["mpconfig_27"] = "Selecione a cor do botão de pagamento";
    $textos["br"]["mpconfig_28"] = "Nota sob o botão";
    $textos["br"]["mpconfig_29"] = "Esta nota aparecerá sob o botão de pagamento. [Opcional]";
    $textos["br"]["mpconfig_30"] = "Exclua cartões de crédito";
    $textos["br"]["mpconfig_31"] = "Marcar esta caixa excluirá os cartões de crédito da lista de métodos de pagamento habilitados.";
    $textos["br"]["mpconfig_32"] = "Excluir ingressos";
    $textos["br"]["mpconfig_33"] = "Marcar esta caixa irá excluir os ingressos da lista de meios de pagamento habilitados.";
    $textos["br"]["mpconfig_34"] = "Excluir cobrança bancária";
    $textos["br"]["mpconfig_35"] = "Marcar esta caixa irá excluir as despesas bancárias da lista de meios de pagamento habilitados.";
    $textos["br"]["mpconfig_36"] = "Excluir cartões de débito";
    $textos["br"]["mpconfig_37"] = "Marcar esta caixa irá excluir os cartões de débito da lista de meios de pagamento habilitados.";
    $textos["br"]["mpconfig_38"] = "Excluir cartões pré-pagos";
    $textos["br"]["mpconfig_39"] = "Marcar esta caixa excluirá os cartões pré-pagos da lista de métodos de pagamento habilitados.";
    $textos["br"]["mpconfig_40"] = "Excluir transferências bancárias";
    $textos["br"]["mpconfig_41"] = "Marcar esta caixa irá excluir as transferências bancárias da lista de meios de pagamento ativados.";
    $textos["br"]["mpconfig_42"] = "Comportamento do módulo";
    $textos["br"]["mpconfig_43"] = "Modo normal";
    $textos["br"]["mpconfig_44"] = "Excluir verificação";
    $textos["br"]["mpconfig_45"] = "Total truncado";
    $textos["br"]["mpconfig_46"] = "Total arredondado";
    $textos["br"]["mpconfig_47"] = "ATENÇÃO: Não modifique esta opção a menos que seja absolutamente necessário.";
    $textos["br"]["mpconfig_48"] = "Não altera o funcionamento normal do módulo";
    $textos["br"]["mpconfig_49"] = "O módulo NÃO verificará a correspondência entre o pagamento creditado no MercadoPago e o valor original da fatura";
    $textos["br"]["mpconfig_50"] = "Apenas a parte total do valor total será enviada ao MercadoPago. Ex: Quantidade original = 485,58 -> Quantidade enviada = 485";
    $textos["br"]["mpconfig_51"] = "O total da fatura será arredondado. Ex: Total: 651,50 => 652 // 651,70 => 652 // 651,29 => 651.";
    $textos["br"]["mpconfig_52"] = "Mostrar erros do MercadoPago";
    $textos["br"]["mpconfig_53"] = "Ao marcar esta caixa, o módulo <b> NÃO irá gerar o botão de pagamento. </b> <br> Em vez disso, exibirá a mensagem de erro do MercadoPago. <br> Recomendamos NÃO usar esta opção a menos que seja absolutamente necessário";
    $textos["br"]["mpconfig_54"] = "Modo de teste";
    $textos["br"]["mpconfig_55"] = "Ao marcar esta caixa, o módulo será executado em modo de teste.";
    $textos["br"]["mpconfig_56"] = "Fatura";
    $textos["br"]["mpconfig_57"] = "Gateway";
    $textos["br"]["mpconfig_58"] = "Transação";
    $textos["br"]["mpconfig_59"] = "Comunicação";
    $textos["br"]["mpconfig_60"] = "Autorização";
    $textos["br"]["mpconfig_61"] = "Encontro";
    $textos["br"]["mpconfig_62"] = "Método de pagamento";
    $textos["br"]["mpconfig_63"] = "Moeda";
    $textos["br"]["mpconfig_64"] = "Total";
    $textos["br"]["mpconfig_65"] = "Valor líquido";
    $textos["br"]["mpconfig_66"] = "Aprovado";
    $textos["br"]["mpconfig_67"] = "Fornecido pelo MercadoPago. Este campo é obrigatório apenas em caso de uso de processamento como Gateway. Se você não sabe o que significa, deixe em branco.";
    $textos["br"]["mpconfig_68"] = "O modo normal é Aggregator. NÃO modifique esta opção a menos que seja absolutamente necessário.";
    $textos["br"]["mpconfig_69"] = "Console do sistema";
    $textos["br"]["mpconfig_70"] = "Callback Email";
    $textos["br"]["mpconfig_71"] = "Se você preencher este campo, o sistema de callback log será ativado.<br>Diferentes parâmetros sobre as comunicações recebidas do MercadoPago serão enviados por e-mail.<br>Para o correto funcionamento, seu servidor deve ter o [mail ()] do PHP.<BR>Para desabilitar esta opção, deixe este campo em branco.";
    $textos["br"]["mpconfig_72"] = "Nome de usuário do administrador WHMCS. ATENÇÃO: Conclua somente se você usar WHMCS versão 7.2 ou inferior.";
    $textos["br"]["mpconfig_73"] = "Moeda do cliente";
    $textos["br"]["mpconfig_74"] = "Quantidade original";
    $textos["br"]["mpconfig_75"] = "Taxa original";
    $textos["br"]["mpconfig_76"] = "Pendente";
    $textos["br"]["mpconfig_77"] = "Fila de processamento de transações";
    $textos["br"]["mpconfig_78"] = "Para evitar transações duplicadas, as transações recebidas do MercadoPago são enfileiradas e processadas uma a uma no Cron do Sistema WHMCS (a cada 5 minutos)";
    $textos["br"]["mercadopago_config_1"] = "Licença de uso para módulos de pagamento do MercadoPago";
    $textos["br"]["mercadopago_config_2"] = "Licença";
    $textos["br"]["mercadopago_config_3"] = "Verificador Local";
    $textos["br"]["mercadopago_config_4"] = "Código de verificação de licença local - NÃO MODIFIQUE!";
    $textos["br"]["mercadopago_config_5"] = "Língua";
    $textos["br"]["mercadopago_config_6"] = "Selecione a linguagem de configuração do módulo.";
    $textos["br"]["mercadopago_activate_1"] = "Ativação bem-sucedida: Clique no botão de configuração para modificar as opções do módulo.";
    $textos["br"]["mercadopago_deactivate_1"] = "O módulo MercadoPago foi desabilitado com sucesso.";
    return $textos[$idioma][$texto];
}