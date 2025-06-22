from flask import Flask, request, jsonify
from gradio_client import Client
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

print("🔁 Connecting to Hugging Face...")
client = Client("Simon-Editor-jnr/project-success-predictor")
print("✅ Hugging Face client ready")

@app.route('/predict', methods=['POST'])
def predict():
    try:
        print("📥 Received request...")
        data = request.get_json()
        inputs = data.get("data", [])
        print("📊 Inputs received:", inputs)

        if len(inputs) != 6:
            print("❌ Invalid input length")
            return jsonify({"error": "Invalid input format"}), 400

        print("🧠 Calling Hugging Face model...")
        result = client.predict(
            inputs[0],
            inputs[1],
            inputs[2],
            inputs[3],
            inputs[4],
            inputs[5],
            api_name="/predict"
        )
        print("✅ Prediction result:", result)
        return jsonify({"prediction": result})
    
    except Exception as e:
        print("❌ Error:", str(e))
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
        import os
        port = int(os.environ.get("PORT", 5000))
        app.run(host="0.0.0.0", port=port)
