import random
from flask import Flask, render_template

app = Flask(__name__)

def sensor_carros():
    return random.randint(0, 50)

def sensor_tempo_espera():
    return random.randint(10, 120)

def sensor_ambulancia():
    return random.choice([True, False])

def decidir_tempo_semaforo(dado):
    if dado["ambulancia"]:
        return 60
    if dado["carros"] > 30:
        return 45
    if dado["tempo_espera"] > 90:
        return 40
    return 30

def detectar_congestionamento(dado):
    return dado["carros"] > 35 and dado["tempo_espera"] > 80

@app.route('/')
def home():

    dados_coletados = []
    for _ in range(10):
        leitura = {
            "carros": sensor_carros(),
            "tempo_espera": sensor_tempo_espera(),
            "ambulancia": sensor_ambulancia()
        }
        
        leitura["tempo_verde"] = decidir_tempo_semaforo(leitura)
        leitura["congestionado"] = detectar_congestionamento(leitura)
        dados_coletados.append(leitura)
    
    # Envia a lista de dados para o arquivo HTML
    return render_template('index.html', dados=dados_coletados)

if __name__ == '__main__':
    app.run(debug=True)