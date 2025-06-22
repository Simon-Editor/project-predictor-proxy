from flask import Flask, request, jsonify
from gradio_client import Client
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

client = Client("Simon-Editor-jnr/project-success-predictor")

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.get_json()
        inputs = data.get("data", [])

        if len(inputs) != 6:
            return jsonify({"error": "Invalid input. Expecting 6 values."}), 400

        result = client.predict(
            inputs[0], inputs[1], inputs[2],
            inputs[3], inputs[4], inputs[5],
            api_name="/predict"
        )
        return jsonify({"prediction": result})

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5001)
