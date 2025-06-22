import pandas as pd
import numpy as np
from sklearn.ensemble import RandomForestClassifier
import pickle

# Load dataset
df = pd.read_csv("project_data.csv")

# Encode tech stack as numbers (adjust if needed)
tech_map = {
    'PHP': 0, 'Python': 1, 'Java': 2, 'JavaScript': 3,
    'C#': 4, 'Node.js': 5, 'Ruby': 6, 'Go': 7
}
df['tech_stack'] = df['tech_stack'].map(tech_map)

# Features and label
X = df[['team_size', 'planning_hours', 'coding_hours', 'gpa_average', 'tech_stack', 'supervisor_experience']]
y = df['success']

# Train model
model = RandomForestClassifier()
model.fit(X, y)

# Save model (without triggering LFS)
with open("model.pkl", "wb") as f:
    pickle.dump(model, f, protocol=4)
