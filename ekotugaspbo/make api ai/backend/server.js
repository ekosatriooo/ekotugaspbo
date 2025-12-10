const express = require("express");
const cors = require("cors");
const path = require("path");
require("dotenv").config();
const OpenAI = require("openai");

const app = express();
app.use(cors());
app.use(express.json());

// Serve frontend
app.use(express.static(path.join(__dirname, "../frontend")));

const client = new OpenAI({
  apiKey: process.env.OPENAI_API_KEY,
  baseURL: "https://openrouter.ai/api/v1"
});

app.post("/api/chat", async (req, res) => {
  try {
    const userMessage = req.body.message;

    console.log("REQ MASUK:", userMessage);

    const completion = await client.chat.completions.create({
      model: "openai/gpt-5.1-chat", 
      max_tokens: 300,                 // BATASI TOKEN → GRATIS
      messages: [
        { role: "user", content: userMessage }
      ]
    });

    const reply = completion.choices[0].message.content;

    return res.json({ reply });

  } catch (err) {
    console.error(err);
    return res.status(500).json({ reply: "Error API backend." });
  }
});

app.listen(3000, () => {
  console.log("Server berjalan di http://localhost:3000");
});
