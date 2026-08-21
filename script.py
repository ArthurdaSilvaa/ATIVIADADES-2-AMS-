import random
import time

servidores = [
    "Servidor 1",
    "Servidor 2",
    "Servidor 3"
]

mensagens_enviadas = 0
mensagens_entregues = 0
mensagens_perdidas = 0
mensagens_duplicadas = 0


def enviar_mensagem():
    global mensagens_enviadas
    global mensagens_entregues
    global mensagens_perdidas
    global mensagens_duplicadas

    mensagem = input("Digite a mensagem: ")

    while True:
        origem = random.choice(servidores)
        destino = random.choice(servidores)

        while destino == origem:
            destino = random.choice(servidores)

        print("\nEnviando mensagem...")
        print("De:", origem)
        print("Para:", destino)

        mensagens_enviadas += 1

        time.sleep(1)

        # 30% de chance de falha
        falha = random.randint(1, 100)

        if falha <= 30:
            print("\nMensagem perdida!")

            mensagens_perdidas += 1

            tentar = input("Deseja tentar enviar novamente? (s/n): ").lower()

            if tentar == "s":
                print("\nTentando enviar novamente...")
                time.sleep(1)
                continue
            else:
                print("Mensagem não enviada.")
                break

        else:
            print("\nMensagem entregue!")
            print("De:", origem)
            print("Para:", destino)
            print("Mensagem:", mensagem)

            mensagens_entregues += 1

            # 20% de chance de mensagem duplicada
            duplicada = random.randint(1, 100)

            if duplicada <= 20:
                print("\nATENÇÃO: A mensagem foi recebida duas vezes!")

                mensagens_duplicadas += 1

                escolha = input(
                    "Deseja excluir a mensagem duplicada ou deixar as duas? "
                    "(excluir/deixar): "
                ).lower()

                if escolha == "excluir":
                    print("Mensagem duplicada excluída.")
                    mensagens_duplicadas -= 1

                elif escolha == "deixar":
                    print("As duas mensagens foram mantidas.")

                else:
                    print("Opção inválida. As duas mensagens serão mantidas.")

            break


def mostrar_estatisticas():
    print("\n========== ESTATÍSTICAS ==========")
    print("Mensagens enviadas:", mensagens_enviadas)
    print("Mensagens entregues:", mensagens_entregues)
    print("Mensagens perdidas:", mensagens_perdidas)
    print("Mensagens duplicadas:", mensagens_duplicadas)
    print("==================================")


while True:
    print("\n============")
    print("Sistemas Distribuídos")
    print("1 - Enviar Mensagem")
    print("2 - Ver Estatísticas")
    print("0 - Sair")

    opcao = input("\nEscolha uma opção: ")

    if opcao == "1":
        enviar_mensagem()

    elif opcao == "2":
        mostrar_estatisticas()

    elif opcao == "0":
        print("Sistema encerrado.")
        break

    else:
        print("\nOpção inválida!")