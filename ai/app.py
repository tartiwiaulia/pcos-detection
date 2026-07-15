from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
import pickle
import numpy as np

app = FastAPI(
    title="PCOS Detection API",
    description="API untuk prediksi PCOS menggunakan model Machine Learning",
    version="1.0"
)

# CORS dibiarkan terbuka untuk kemudahan pengembangan lokal. Di alur produksi,
# permintaan masuk lewat backend Laravel (PredictionController), bukan langsung dari browser.
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

# Load model AI
with open("pcos_model.pkl", "rb") as model_file:
    model = pickle.load(model_file)

# Load scaler
with open("pcos_scaler.pkl", "rb") as scaler_file:
    scaler = pickle.load(scaler_file)

# Urutan wajib sama dengan scaler.feature_names_in_ saat training:
# ['BMI', 'Age (yrs)', 'Cycle(R/I)', 'Weight gain(Y/N)', 'hair growth(Y/N)',
#  'Pimples(Y/N)', 'Hair loss(Y/N)', 'Skin darkening (Y/N)',
#  'Fast food (Y/N)', 'Reg.Exercise(Y/N)']


class PemeriksaanInput(BaseModel):
    age: int
    weight: float
    height: float
    cycle_irregularity: bool
    weight_gain: bool
    hirsutism: bool
    severe_acne: bool
    hair_loss: bool
    dark_skin: bool
    fast_food: bool
    reg_exercise: bool


class PemeriksaanOutput(BaseModel):
    prediction: int
    risk_score: float
    risk_level: str


@app.get("/health")
def health():
    return {"status": "ok"}


@app.post("/predict", response_model=PemeriksaanOutput)
def predict(data: PemeriksaanInput):
    height_m = data.height / 100
    bmi = data.weight / (height_m * height_m)

    features = np.array([[
        bmi,
        data.age,
        int(data.cycle_irregularity),
        int(data.weight_gain),
        int(data.hirsutism),
        int(data.severe_acne),
        int(data.hair_loss),
        int(data.dark_skin),
        int(data.fast_food),
        int(data.reg_exercise),
    ]])

    scaled = scaler.transform(features)
    prediction = int(model.predict(scaled)[0])
    probability = float(model.predict_proba(scaled)[0][1])
    risk_score = round(probability * 100, 1)

    if risk_score < 35:
        risk_level = "Rendah"
    elif risk_score < 70:
        risk_level = "Sedang"
    else:
        risk_level = "Tinggi"

    return PemeriksaanOutput(
        prediction=prediction,
        risk_score=risk_score,
        risk_level=risk_level,
    )
