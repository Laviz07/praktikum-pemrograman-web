function contohLet() {
	let y = 10;

	if (true) {
		let y = 20;
		console.log("Nilai dalam blok: ", y);
	}

	console.log("Nilai diluar blok: ", y);
}

contohLet();

let nama = "Budi";
let umur = 30;
let isStudent = false;
let buah = ["Apel", "Mangga", "Jeruk"];
let mahasiswa = { nama: "Rina", usia: 20, jurusan: "Informatika" };

console.log(
	"Nama: ",
	nama,
	"\nUmur: ",
	umur,
	"\nMahasiswa Aktif: ",
	isStudent,
	"\nBuah Favorit: ",
	buah[1],
	"\nJurusan: ",
	mahasiswa.jurusan,
);
