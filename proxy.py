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
            return jsonify({"error": "Invalid input format"}), 400

        result = client.predict(
            inputs[0],  # team_size
            inputs[1],  # planning_hours
            inputs[2],  # coding_hours
            inputs[3],  # gpa_average
            inputs[4],  # tech_stack
            inputs[5],  # supervisor_experience
            api_name="/predict"
        )

        return jsonify({"prediction": result})
    
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000)
