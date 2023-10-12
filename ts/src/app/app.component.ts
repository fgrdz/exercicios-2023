import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { ImageLoader } from '@angular/common';



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
  imagemSrc = '/ts/src/assets/dewey 1.svg'

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