// ambil elemen-elemen yang diperlukan
const nimInput = document.getElementById("nimInput");
const nilaiInput = document.getElementById("nilaiInput");
const cekBtn = document.getElementById("cekBtn");
const resultBox = document.getElementById("resultBox");

function cekNilai() {
	const nim = nimInput.value.trim(); // NIM bisa kosong
	const nilaiStr = nilaiInput.value.trim();

	// konversi ke number
	const nilai = Number(nilaiStr);

	if (nilai < 0 || nilai > 100 || isNaN(nilai)) {
		resultBox.innerHTML = `<div class="error-message"><i class="fas fa-ban"></i> Nilai tidak valid!</div>`;
		return;
	}

	// menentukan grade
	let hurufMutu = "";
	let deskripsi = "";
	let pesan = "";
	let gradeClass = "";

	if (nilai >= 80) {
		hurufMutu = "A";
		deskripsi = "Sangat Baik";
		pesan = "Pertahankan prestasimu! Kamu sudah berada di jalur yang tepat.";
		gradeClass = "gradeA";
	} else if (nilai >= 70) {
		hurufMutu = "B";
		deskripsi = "Baik";
		pesan = "Kerja bagus! Sedikit usaha lagi kamu bisa mencapai A.";
		gradeClass = "gradeB";
	} else if (nilai >= 60) {
		hurufMutu = "C";
		deskripsi = "Cukup";
		pesan = "Masih bisa ditingkatkan. Terus belajar dan jangan menyerah!";
		gradeClass = "gradeC";
	} else if (nilai >= 50) {
		hurufMutu = "D";
		deskripsi = "Kurang";
		pesan = "Perlu lebih banyak latihan. Kamu pasti bisa memperbaikinya!";
		gradeClass = "gradeD";
	} else {
		hurufMutu = "E";
		deskripsi = "Sangat Kurang";
		pesan = "Jangan putus asa. Mulai belajar lagi dan tingkatkan usahamu!";
		gradeClass = "gradeE";
	}

	// menampilkan hasil
	resultBox.innerHTML = `
	<div class="result-content">
		<span class="grade ${gradeClass}">${hurufMutu}</span>
		<p class="grade-desc">${deskripsi}</p>
		<p class="motivation">${pesan}</p>
		<p class="nim-display">
		<i class="fas fa-id-card"></i> NIM: ${nim}
		</p>
	</div>
	`;
}

//mengaktifkan tombol cek nilai
function toggleButton() {
	if (nimInput.value.trim() !== "" && nilaiInput.value.trim() !== "") {
		cekBtn.disabled = false;
	} else {
		cekBtn.disabled = true;
	}
}

nimInput.addEventListener("input", toggleButton);
nilaiInput.addEventListener("input", toggleButton);

// event listener tombol
cekBtn.addEventListener("click", cekNilai);

// jika user tekan Enter di input nilai, tombol diklik
nilaiInput.addEventListener("keypress", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();
		cekBtn.click();
	}
});

// jika user tekan enter di NIM juga bisa trigger (optional)
nimInput.addEventListener("keypress", function (e) {
	if (e.key === "Enter") {
		e.preventDefault();
		cekBtn.click();
	}
});
