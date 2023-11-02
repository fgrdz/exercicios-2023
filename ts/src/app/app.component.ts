import { Component } from '@angular/core';



@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'DevChuva';
  assunto: String = ''
  conteudo:  String = ''
  mostrarResumoVisivel = true; 
  mostrarFormulario = false;
  mostrarMensagem=  false;
  mostrarComentarios = false;
  iconName: string = 'fa-solid fa-comments';

  toggleResumo() {
    this.mostrarResumoVisivel = !this.mostrarResumoVisivel;
}
  toggleFormulario(){
    this.mostrarFormulario = !this.mostrarFormulario;
    this.mostrarMensagem = false;
  }
  toggleMensagem(){
    this.mostrarMensagem =!this.mostrarMensagem;
  }
  toggleComentario(){
    this.mostrarComentarios = !this.mostrarComentarios;
  }
  onSubmitForm(event: Event){

    event.preventDefault();

   
    this.mostrarFormulario = false;

    this.assunto = '';
    this.conteudo = '';

  }
  
  
}