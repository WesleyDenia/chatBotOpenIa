<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Context;

class ContextSeeder extends Seeder
{
    public function run()
    {
        $contexts = [
            [
                'keyword' => '6429',
                'context' => 'ALTERAR ESTADO',
            ],
            [
                'keyword' => 'localização,endereço,quem somos,onde,ficam,fica,informação,informações,localiza',
                'context' => '
                *Localização:*
                Estamos localizados na Rua Filarmônica Artistica Pombalense, 17 Pombal, em frente à Câmara Municipal de Serviços Técnicos ao lado da feira dos ciganos. Localização Google Maps: https://www.google.com/maps/place/Salgados+Do+Marqu%C3%AAs/@39.9130046,-8.6338658,17z/data=!3m1!4b1!4m6!3m5!1s0xd22676dff9e3169:0xcb6b0c464394f4ce!8m2!3d39.9130005!4d-8.6312909!16s%2Fg%2F11w3l4m_6v?entry=ttu&g_ep=EgoyMDI1MDEwNy4wIKXMDSoASAFQAw%3D%3D .',
            ],
            [
                'keyword' => 'pack,packscoxinhas,sabor,sabores,produto,produtos,vendem,tem,salgados,salgado,kibe,enroladinho,salsicha,bolinha,queijo,travesseirinho,carne,preço,preços,valor,valores,custa,custo,quanto,encomenda,encomendar',
                'context' => '
                *Produtos disponíveis:*

                *Salgados de 70g:*
                - Coxinha de Frango
                - Coxinha de Fiambre e Queijo
                - Coxinha de Leitão
                - Coxinha de Bacalhau
                - Kibe.

                *Minis salgados 20g, também chamados de salgados de festa:*
                - Coxinha de Frango
                - Enroladinho de Salsicha
                - Travesseirinho de Carne
                - Bolinha de Queijo
                - Kibe
                - Pack Mix(também conhecido como mistos ou sortidos).

                *Preço dos salgados de 70g: 0.79€*

                *Preços dos salgados de festa (minis):*
                1 pack (25 unidades) - 9€
                2 packs (50 unidades) - 16,80€
                3 packs (75 unidades) - 25,20€
                4 packs (100 unidades) - 30€
                5 packs (125 unidades) - 39€
                6 packs (150 unidades) - 46,80€
                7 packs (175 unidades) - 55,20€
                8 packs (200 unidades) - 60€',
            ],
            [
                'keyword' => 'promoção,desconto,grandes quantidades',
                'context' => '
                *Promoções:*
                Nas quartas e quintas na compra de um pack de mini o segundo sai com 50½ de desconto. ',
            ],
            [
                'keyword' => 'atendimento,funcionamento,horário,whatsapp,contato,aberto,hora,horas,encomenda,recolha,encomendar,pedir,pedido',
                'context' => '
                *Horários de Funcionamento:*
                - Segunda, Quarta, Quinta, Sexta, Sábado: das 12h às 21h.
                - Terças e Domingos: Encerrados. ',
                'completion' => '. Não aceite encomendas fora do horário de funcionamento. '
            ],
            [
                'keyword' => 'tempo, recolha, duração, dias, dia',
                'context' => 'Aceitamos encomendas de até 100 unidades com 3 horas de antecedencia para encomendas maiores a antecedencia mínima é 24 horas mediante o stock. ',
            ],
            [
                'keyword' => 'encomendar,pedido,encomenda,comprar,pedir,quero,queria',
                'context' => '
                *Formulário de Encomenda Completo:*
                - *Nome completo:*
                - *Telefone de contato:*
                - *Data/hora da entrega:*
                - *Quantidade e sabor do produto:*

                *IMPORTANTE:*
                1. Nunca finalize a encomenda sem antes confirmar que TODAS as informações acima foram coletadas e validadas.
                2. Caso algum dado esteja faltando, liste os dados que já foram recebidos e solicite educadamente o restante.
                3. Quando tiver posse de todas as informações Inclua **obrigatoriamente** uma linha com o status: STATUS: ENCOMENDA_FINALIZADA.
                4. Nunca peça ao cliente para ele incluir a linha "STATUS: ENCOMENDA_FINALIZADA", essa linha deve ser incluida pelo assistent.
                5. O pagamento pode ser feito no momento da recolha',
                'completion' => '
                *Referente a venda/encomenda:*
                1. Os salgados de 70g (Coxinha de frango, coxinha de fiambre e queijo, coxinha de leitão, coxinha de bacalhau e kibe) são vendidos a unidade.
                2. Os minis salgados *só podem ser vendidos* em múltiplos de 25 unidades. Se o cliente pedir uma quantidade diferente, explique educadamente a regra.
                3. Caso o cliente peça 25 salgados ou mais, pressuponha que ele esteja a falar dos salgados de festa.
                4. Caso o cliente peça uma quantidade de minis inválida nunca sugira que ele complete com os salgados vendidos a unidade, e sim que ele ajuste a quantidade adquerindo mais ou menos packs.
                5. Caso o cliente peça acima de 25 unidades faça o calculo para descobrir a quantidade de packs o mesmo deseja encomendar, não pergunte isso ao cliente.'
            ],
            [
                'keyword' => 'entregas,entrega,delivery,entregam,entregar',
                'context' => 'Não fazemos entregas, porém estamos no Glovo, Uber Eats e Pede & Comoe, caso você queira receber seus salgados em domicílio pode comprar pelos aplicativos',
            ],
        ];

        foreach ($contexts as $context) {
            Context::create($context);
        }
    }
}
